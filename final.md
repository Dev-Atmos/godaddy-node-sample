# Interview Preparation Guide

A comprehensive collection of technical interview questions and answers, organized by technology and topic for quick reference.

---

## **Node.js**

### Core & Runtime

1. **What is Node.js and how does it work?**
   Node.js is a JavaScript runtime built on V8 with a single-threaded event loop and `libuv` for async I/O. It offloads I/O to the OS/libuv threadpool, avoiding thread-per-request.

2. **If Node is single-threaded, how does it handle concurrency?**
   Through non-blocking I/O and the event loop. Blocking tasks (disk, network, DNS, crypto) are delegated; callbacks/promises resume on completion.

3. **Explain the Event Loop phases.**
   Phases: timers → pending callbacks → idle/prepare → poll → check → close callbacks. Microtasks (Promises, `process.nextTick`) run between macrotasks, with `nextTick` prioritized.

4. **`process.nextTick()` vs `setImmediate()` vs `setTimeout(fn, 0)`**

* **nextTick**: Runs before the next event loop phase (highest priority).
* **setImmediate**: Runs in the check phase.
* **setTimeout**: Runs in timers phase; actual timing depends on the loop.

5. **require vs import**

* `require`: CommonJS, synchronous.
* `import`: ESM, static, top-level await, tree-shakeable.

6. **Why are Buffers needed?**
   For binary data handling (files, sockets). Buffers are byte arrays mapping to raw memory, unlike UTF-16 JS strings.

---

### Asynchrony & Patterns

7. **Callbacks vs Promises vs async/await**

* Callbacks: Simple but lead to pyramid-of-doom.
* Promises: Composable via `then/catch`.
* async/await: Linear style on top of promises.

8. **Promise combinators**:

* all: Fails fast.
* allSettled: Resolves always.
* race: First settle wins.
* any: First fulfilled wins.

9. **Sequential async calls**: Use `for...of` with `await`.

---

### Streams & Backpressure

10. **What are Node streams and types?**
    Readable, Writable, Duplex, Transform — enable chunked processing and backpressure.

11. **Handle backpressure**: Use `stream.pipeline`.

---

### File System / Large Files

12. **Read large file line-by-line**: Use `readline` with `createReadStream`.
13. **`fs.readFile` vs `fs.createReadStream`**: First loads all into memory; second streams.

---

### HTTP & Express

14. **Bare HTTP server**: Use `http.createServer`.
15. **What is middleware?** Function `(req, res, next)` for processing requests.
16. **Error handling in Express**: Use a 4-arg middleware.
17. **CORS in Express**: Use `cors` package.
18. **Securing an Express API**: Use helmet, input validation, JWT/OAuth, HTTPS.

---

## **React.js**

### Core Concepts

1. **What is React?**
   A UI library for component-based views with declarative rendering and virtual DOM.

2. **JSX — what and why?**
   Syntax sugar for `React.createElement`.

3. **Functional vs Class components**: Modern React prefers functions + hooks.

4. **Props vs State**: Props are read-only inputs; state is mutable, triggers re-render.

5. **Why keys?**
   For stable identity in lists to ensure proper reconciliation.

---

### Rendering & Lifecycle

* Rendering: React diffs virtual DOM with previous tree.
* Lifecycle mapping: `componentDidMount` → `useEffect(() => {}, [])`.
* When React re-renders: State/props/context change.

---

### Hooks

* `useState` batching.
* `useEffect` vs `useLayoutEffect`.
* `useMemo` / `useCallback`.
* `useRef`.
* `useReducer`.
* Concurrent features: `useTransition`, `useDeferredValue`.

---

## **SQL**

### Basic

1. **INNER JOIN vs LEFT JOIN**:

* INNER: Only matching rows.
* LEFT: All left rows, NULLs for unmatched right rows.

2. **Primary Key vs Unique Key**:

* PK: Unique + not null.
* Unique: Allows null.

3. **Normalization**: Process to reduce redundancy.
4. **Indexes**: Clustered, non-clustered, unique, full-text.

---

### Intermediate

1. **Subquery vs JOIN**: Subquery is nested; join merges rows.
2. **GROUP BY vs HAVING**: HAVING filters aggregates.
3. **Transaction & ACID**.
4. **Self join**.

---

## **SSIS, SSRS, SSAS**

### SSIS

* Lookup vs Merge Join.
* Handling NULLs.
* Transformations.
* Data Flow vs Control Flow.

### SSRS

* Conditional formatting with expressions.
* Deploying reports.
* Parameters: query, multi-value, cascading.
* Role of Report Manager.

### SSAS

* OLAP vs Data Mining.
* Creating hierarchies.
* Calculated member vs measure.

---

## **DBA & SQL Agent**

### DBA

* SQL Profiler.
* Performance monitoring.
* Full vs differential backup.
* Replication types.

### SQL Agent

* Job vs Step.
* Monitoring jobs.
* Agent proxies.
* Handling job failures.

---

## **Security**

* Common risks: SQL injection, XSS, CSRF.
* Managing env vars.
* Secrets storage.
* PII handling.

---

## **Performance & Ops**

* Scaling across cores.
* Worker threads.
* Diagnosing slowdowns.
* Memory leak detection.

---

## **System Design Scenarios**

* Document intake pipeline.
* E-commerce search.
* Multi-region HA.

---

## **Testing**

* Unit vs Integration vs E2E.
* Jest + Supertest.
* Mocking external services.

---

This `.MD` file format makes it easy to navigate and prepare for technical interviews across multiple domains.
