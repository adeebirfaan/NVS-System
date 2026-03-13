# NVS-System Development Guide

This document provides instructions for coding agents working on the Laravel 12 News Verification System (NVS-System).

## Project Overview

- **Project Name:** NVS-System (News Verification System)
- **Framework:** Laravel 12
- **PHP Version:** 8.2+
- **Database:** MySQL
- **Frontend:** Blade templating + Bootstrap 5
- **Authentication:** Laravel built-in (session-based)

## System Actors

1. **Public User** - Regular citizens who submit news for verification
2. **MCMC Staff** - Government regulatory body staff who manage the system
3. **Agency Staff** - Partner agency staff (e.g., Police, Health Ministry) who investigate inquiries

## Core Modules

1. **Manage User** - Registration, login, role-based access, agency management
2. **Manage Inquiry Form Submission** - Submit, browse, filter inquiries
3. **Inquiry Assignment to Agencies** - MCMC assigns inquiries to agencies
4. **Inquiry Progress Tracking** - Status updates, history, reporting

---

## Development Guidelines

### General Principles

- Follow Laravel 12 conventions strictly
- Use Blade templates with Bootstrap 5 for UI
- Keep code simple, readable, and beginner-friendly
- Avoid unnecessary packages unless clearly justified
- Use Eloquent ORM for database operations
- Implement vertical slices (complete feature at a time)

### Code Structure

- **Models:** `app/Models/` - Eloquent models
- **Migrations:** `database/migrations/` - Database schema
- **Controllers:** `app/Http/Controllers/` - Business logic
- **Views:** `resources/views/` - Blade templates
- **Seeders:** `database/seeders/` - Test data
- **Policies:** `app/Policies/` - Authorization (when needed)
- **Requests:** `app/Http/Requests/` - Form request validation

### Database

- Use MySQL-compatible migrations
- Always use foreign keys with appropriate constraints
- Include soft deletes where appropriate
- Use proper indexes for frequently queried columns
- Prefix tables if needed for naming clarity

### Authentication & Authorization

- Use Laravel's built-in session authentication
- Implement role-based access using custom middleware
- Use policies for model-level authorization
- Always validate user permissions before actions

### Routes

- Use named routes for all route definitions
- Group routes by prefix and middleware
- Use RESTful controller conventions
- Document complex route logic with comments

### Validation

- Use Form Request classes for complex validation
- Use controller-based validation for simple cases
- Always validate input before database operations

---

## Implementation Workflow

### Before Writing Any Code

1. Analyze existing project structure
2. Read relevant existing files to understand patterns
3. Plan the architecture and database schema
4. Propose the plan before implementing

### After Each Implementation Step

1. Test the feature manually
2. Run migrations if needed
3. Run seeders if needed
4. Verify routes work correctly
5. Explain what was created

### Testing Instructions Format

After each feature implementation, include:

```
### How to Test
1. Run `php artisan migrate:fresh --seed` (if new migrations)
2. Start server: `php artisan serve`
3. Visit the relevant URL
4. Test the feature with different user roles
5. Verify expected behavior
```

---

## Current Project State

### Completed Features

- **Module 1: User Management**
  - Database: Extended users table with role, agency_id, is_active
  - Agencies table for partner organizations
  - AuthController for login/register/logout
  - UserController for MCMC user management
  - AgencyController for agency CRUD
  - Role-based middleware (EnsureUserIsMcmc, EnsureUserIsAgency)
  - Dashboards for each role

### Pending Features

- Module 2: Inquiry Form Submission
- Module 3: Inquiry Assignment to Agencies
- Module 4: Inquiry Progress Tracking

---

## Important Constraints

1. **Do NOT generate everything at once** - Work module by module
2. **Always inspect existing files** before editing
3. **Make small, safe changes** - Avoid large refactors
4. **Explain every major change** - Document your work
5. **Preserve MySQL compatibility** - Avoid SQLite-specific features
6. **Use role-based access** consistently
7. **Prefer Form Request validation** for complex forms
8. **Use named routes** everywhere
9. **Never break existing code** - Test thoroughly
10. **Ask for confirmation** before large refactors

---

## Quick Reference

### Running the Application

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations and seeders
php artisan migrate:fresh --seed

# Start development server
php artisan serve
```

### Default Seeder Accounts

| Role | Email | Password |
|------|-------|----------|
| MCMC Admin | admin@mcmc.gov.my | password |
| Agency Staff | staff@polis.gov.my | password |

### Key Routes

| Route | Description |
|-------|-------------|
| / | Home page |
| /login | User login |
| /register | Public registration |
| /dashboard | Redirects based on role |
| /mcmc/dashboard | MCMC dashboard |
| /agency/dashboard | Agency dashboard |

---

## Next Steps

Proceed with **Module 2: Inquiry Form Submission** following the architecture plan already documented. Implement in this order:

1. Create Inquiry migration and model
2. Create InquiryStatusHistory migration and model
3. Create PublicInquiryController
4. Create McmcInquiryController
5. Create AgencyInquiryController
6. Add routes
7. Create Blade views
8. Test thoroughly
