HPP Average (FIFO-like Moving Average) – Laravel API

A small Laravel API that calculates cost of goods sold (COGS) using the moving average (a.k.a. weighted average) method with backdated inserts (“sisipan”) support.
It provides CRUD endpoints for purchase/sale transactions and recalculates the entire chronology whenever data changes, while strictly enforcing “stock must never go negative”.

✨ Features

CRUD API for transactions (purchase/sale)

Moving Average HPP (COGS) calculation per the given rules (see Logic)

Backdated inserts/updates (“sisipan”) recalc all subsequent rows

Anti-negative stock validation (insert/update/delete)

Atomicity: CRUD and recalc happen inside a single DB transaction

Form Requests validation (Store & Update)

MySQL storage with proper decimal precision

Seed data (initial, inserted/mid-stream, final)

Minimal Blade UI demo (Bootstrap 5 + Tailwind via CDN) — no npm, one terminal run

🧠 Domain Logic (as required)

Given a row with type = Pembelian (Purchase) or Penjualan (Sale):

Cost

Purchase: cost = price (from input)

Sale: cost = previous HPP (moving average up to the previous row)

Total Cost
total_cost = qty × cost
(Sales use negative qty effectively; see Qty handling below.)

Qty Balance
qty_balance = previous_qty_balance + qty_input
For sales, the effective qty is negative.

Value Balance
value_balance = previous_value_balance + total_cost

HPP (Average Cost)
hpp = value_balance / qty_balance (when qty ≠ 0)

Backdated Inserts (“Sisipan”)
Any row added/edited with an earlier date affects all subsequent rows.

No Negative Stock
If at any step next_qty_balance < 0, the operation is rejected with HTTP 422.

Qty input convention

Purchases: qty > 0

Sales: you may send negative qty (recommended, matches examples)
If a positive qty is sent for a sale, the service normalizes it to negative during calculation.

Ordering of rows

Primary: date ASC

Within the same date: Purchases first, then Sales

Lastly: id ASC (stable tiebreaker)

This mirrors typical inventory flows (buy first, then sell on the same day) and matches the provided examples.

🧱 Tech Stack

Laravel (v11/12)

MySQL

PHP ≥ 8.1

Minimal Blade UI (Bootstrap 5 + Tailwind CDN with tw- prefix)

📦 Data Model

Table: transactions (suggested columns)

id (PK)

type enum/string: Pembelian | Penjualan

date DATE

qty DECIMAL(18,6) — raw user input (sales can be negative)

price DECIMAL(18,6) nullable — required for purchases, ignored for sales

Computed & persisted (for audit):

qty_effective DECIMAL(18,6)

cost DECIMAL(18,6)

total_cost DECIMAL(18,6)

qty_balance DECIMAL(18,6)

value_balance DECIMAL(18,6)

hpp DECIMAL(18,6)

Timestamps

Persisting computed columns makes it easy to audit and display the evolution of balances/HPP exactly like the sample sheet.
