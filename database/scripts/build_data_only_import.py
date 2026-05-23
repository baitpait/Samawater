#!/usr/bin/env python3
"""
Extract INSERT statements from a mysqldump (structure + data) for data-only import.
- Skips migrations, cache, sessions (keeps Laravel migration history; avoids session noise).
- Rewrites clients INSERT to explicit columns so DBs with extra columns (e.g. opening_balance_*) accept rows.
- Prepends TRUNCATE (FK checks off) for tables being loaded so import replaces data without duplicate keys.

Usage:
  python3 database/scripts/build_data_only_import.py \\
    /path/to/dump.sql \\
    /path/to/out.sql
"""

from __future__ import annotations

import re
import sys

SKIP_INSERT_TABLES = frozenset({"migrations", "cache", "sessions"})

# Column list matching the backup dump (before opening_balance_* were added).
CLIENTS_COLUMN_LIST = (
    "(`id`, `parent_id`, `contract_no`, `name`, `city_id`, `address`, `phone_one`, "
    "`phone_two`, `client_type`, `subscription_type_id`, `subscription_status_id`, "
    "`subscription_start_date`, `longitude`, `latitude`, `bottle_balance`, "
    "`delivery_on_demand`, `distributor_id`, `image`, `notes`, `created_at`, `updated_at`)"
)

# Truncate these before load (FK checks disabled). Must cover all tables we INSERT into.
TRUNCATE_TABLES = [
    "client_deposit_items",
    "client_deposits",
    "invoice_items",
    "invoices",
    "deliveries",
    "client_payments",
    "expense_monthly_allocations",
    "expenses",
    "clients",
    "users",
    "vendor_payments",
    "vendors",
    "inventory_items",
    "expense_categories",
    "distributors",
    "cities",
    "client_types",
    "subscription_statuses",
    "subscription_types",
    "roles",
    "cache",
    "cash_withdraws",
]


def extract_insert_blocks(lines: list[str]) -> list[tuple[str, str]]:
    """Return list of (table_name, full_insert_sql)."""
    blocks: list[tuple[str, str]] = []
    i = 0
    n = len(lines)
    insert_re = re.compile(r"^INSERT INTO `([^`]+)` VALUES")
    while i < n:
        line = lines[i]
        m = insert_re.match(line)
        if not m:
            i += 1
            continue
        table = m.group(1)
        chunk = [line]
        j = i
        while j < n and not lines[j].rstrip().endswith(");"):
            j += 1
            if j < n:
                chunk.append(lines[j])
        if j >= n:
            raise RuntimeError(f"Unterminated INSERT for `{table}` starting line {i + 1}")
        stmt = "\n".join(chunk)
        blocks.append((table, stmt))
        i = j + 1
    return blocks


def main() -> int:
    if len(sys.argv) != 3:
        print("Usage: build_data_only_import.py <input_dump.sql> <output_import.sql>", file=sys.stderr)
        return 1
    in_path, out_path = sys.argv[1], sys.argv[2]
    with open(in_path, "r", encoding="utf-8", errors="replace") as f:
        lines = f.read().splitlines()

    blocks = extract_insert_blocks(lines)
    filtered: list[str] = []
    for table, stmt in blocks:
        if table in SKIP_INSERT_TABLES:
            continue
        if table == "clients":
            stmt = stmt.replace(
                "INSERT INTO `clients` VALUES",
                f"INSERT INTO `clients` {CLIENTS_COLUMN_LIST} VALUES",
                1,
            )
        filtered.append(stmt)

    header = """-- Data-only import (generated). Review TRUNCATE list before production use.
/*!40101 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET TIME_ZONE='+00:00' */;

"""
    trunc = "\n".join(f"TRUNCATE TABLE `{t}`;" for t in TRUNCATE_TABLES) + "\n\n"
    footer = """
/*!40101 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
"""

    out = header + trunc + "\n\n".join(filtered) + footer
    with open(out_path, "w", encoding="utf-8") as f:
        f.write(out)
    print(f"Wrote {out_path} ({len(filtered)} INSERT batches).")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
