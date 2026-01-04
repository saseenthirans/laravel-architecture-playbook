# Laravel Aggregate Query with Caching (Senior-Level Example)

## Problem
In a high-traffic system, we need to frequently retrieve the number of
completed tasks for a project. The dataset can contain millions of rows,
and the endpoint must remain fast and scalable.

## Solution
This implementation introduces a dedicated **domain service** that:
- Uses a single SQL aggregate (`COUNT`)
- Avoids loading models into memory
- Caches the computed result for a short TTL
- Keeps controllers thin and testable

## Architecture Decision
- Query and caching logic live in a **domain layer**, not controllers
- Only scalar results are cached (not Eloquent models)
- Cache keys are explicit and deterministic
- The class is stateless and easily movable into a microservice

## Why This Is Senior-Level
- Optimized for read-heavy production workloads
- Avoids common Eloquent and caching anti-patterns
- Respects clean architecture and separation of concerns
- Designed with queues, APIs, and horizontal scaling in mind

## Possible Extensions
- Event-driven cache invalidation (`TaskCompleted`)
- Projection table updated via queue workers
- Read replica support for analytics traffic
