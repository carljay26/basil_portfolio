-- ============================================================
-- Basil Portfolio — Full Database Schema
-- No generic `users` table; admin credentials use admin_accounts.
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS site_views;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS satisfactions;
DROP TABLE IF EXISTS tools;
DROP TABLE IF EXISTS skills;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS experiences;
DROP TABLE IF EXISTS profiles;
DROP TABLE IF EXISTS admin_accounts;
DROP TABLE IF EXISTS password_reset_tokens;
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS cache;
DROP TABLE IF EXISTS cache_locks;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS job_batches;
DROP TABLE IF EXISTS failed_jobs;
DROP TABLE IF EXISTS migrations;

SET FOREIGN_KEY_CHECKS = 1;

-- ─── Laravel system tables ────────────────────────────────────────────────────

CREATE TABLE migrations (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration       VARCHAR(255) NOT NULL,
    batch           INT NOT NULL
);

CREATE TABLE sessions (
    id            VARCHAR(255)  NOT NULL PRIMARY KEY,
    user_id       BIGINT UNSIGNED NULL,
    ip_address    VARCHAR(45)   NULL,
    user_agent    TEXT          NULL,
    payload       LONGTEXT      NOT NULL,
    last_activity INT           NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);

CREATE TABLE cache (
    `key`       VARCHAR(255) NOT NULL PRIMARY KEY,
    `value`     MEDIUMTEXT   NOT NULL,
    expiration  INT          NOT NULL
);

CREATE TABLE cache_locks (
    `key`       VARCHAR(255) NOT NULL PRIMARY KEY,
    owner       VARCHAR(255) NOT NULL,
    expiration  INT          NOT NULL
);

CREATE TABLE jobs (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue        VARCHAR(255) NOT NULL,
    payload      LONGTEXT     NOT NULL,
    attempts     TINYINT UNSIGNED NOT NULL,
    reserved_at  INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at   INT UNSIGNED NOT NULL,
    INDEX jobs_queue_index (queue)
);

CREATE TABLE job_batches (
    id             VARCHAR(255) NOT NULL PRIMARY KEY,
    name           VARCHAR(255) NOT NULL,
    total_jobs     INT NOT NULL,
    pending_jobs   INT NOT NULL,
    failed_jobs    INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options        MEDIUMTEXT NULL,
    cancelled_at   INT NULL,
    created_at     INT NOT NULL,
    finished_at    INT NULL
);

CREATE TABLE failed_jobs (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid       VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT         NOT NULL,
    queue      TEXT         NOT NULL,
    payload    LONGTEXT     NOT NULL,
    exception  LONGTEXT     NOT NULL,
    failed_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE password_reset_tokens (
    email      VARCHAR(255) NOT NULL PRIMARY KEY,
    token      VARCHAR(255) NOT NULL,
    created_at TIMESTAMP    NULL
);

-- ─── Admin Account ────────────────────────────────────────────────────────────
-- Replaces the generic Laravel `users` table.

CREATE TABLE admin_accounts (
    id                BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name              VARCHAR(255) NOT NULL,
    email             VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP    NULL,
    password          VARCHAR(255) NOT NULL,
    remember_token    VARCHAR(100) NULL,
    created_at        TIMESTAMP    NULL,
    updated_at        TIMESTAMP    NULL
);

-- ─── Profile ──────────────────────────────────────────────────────────────────
-- One row = the portfolio owner.

CREATE TABLE profiles (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    -- Hero / Identity
    name                VARCHAR(255) NOT NULL DEFAULT '',       -- Full name
    title               VARCHAR(255) NULL,                     -- e.g. UI/UX Designer
    tagline             VARCHAR(500) NULL,                     -- Hero tagline
    availability        VARCHAR(255) NULL,                     -- e.g. Open to Work
    profile_image_url   VARCHAR(1000) NULL,                   -- Profile picture URL

    -- About Me
    bio                 TEXT         NULL,                     -- Biography / About Me text

    -- Contact (displayed publicly)
    email               VARCHAR(255) NULL,
    phone               VARCHAR(50)  NULL,
    location            VARCHAR(255) NULL,

    -- Contact links
    gmail_url           VARCHAR(1000) NULL,
    facebook_url        VARCHAR(1000) NULL,
    discord_url         VARCHAR(1000) NULL,

    -- Extra details
    current_engagement  VARCHAR(255) NULL,                    -- Current Professional Engagement
    languages           VARCHAR(255) NULL,                    -- e.g. English, Filipino
    quote               TEXT         NULL,
    resume_url          VARCHAR(1000) NULL,

    -- Hero stats (manually managed numbers)
    experience_years    SMALLINT UNSIGNED NULL,
    projects_count      INT UNSIGNED      NULL,
    clients_count       INT UNSIGNED      NULL,
    satisfaction_score  VARCHAR(50)       NULL,                -- e.g. 4.9/5

    created_at          TIMESTAMP NULL,
    updated_at          TIMESTAMP NULL
);

-- ─── Experiences ──────────────────────────────────────────────────────────────

CREATE TABLE experiences (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profile_id  BIGINT UNSIGNED NOT NULL,
    title       VARCHAR(255) NOT NULL,                        -- Job title
    company     VARCHAR(255) NULL,
    role        VARCHAR(255) NULL,                            -- e.g. Full-time / Freelance
    description TEXT         NULL,
    start_date  VARCHAR(50)  NULL,
    end_date    VARCHAR(50)  NULL,
    is_current  TINYINT(1)   NOT NULL DEFAULT 0,
    position    INT UNSIGNED NOT NULL DEFAULT 0,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT fk_experiences_profile FOREIGN KEY (profile_id) REFERENCES profiles (id) ON DELETE CASCADE
);

-- ─── Projects ─────────────────────────────────────────────────────────────────

CREATE TABLE projects (
    id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profile_id    BIGINT UNSIGNED NOT NULL,
    title         VARCHAR(255) NOT NULL,
    subtitle      VARCHAR(255) NULL,
    client_name   VARCHAR(255) NULL,
    status        ENUM('draft','published','archived') NOT NULL DEFAULT 'draft',
    summary       TEXT         NULL,
    thumbnail_url VARCHAR(1000) NULL,
    featured      TINYINT(1)   NOT NULL DEFAULT 0,
    position      INT UNSIGNED NOT NULL DEFAULT 0,
    created_at    TIMESTAMP NULL,
    updated_at    TIMESTAMP NULL,
    CONSTRAINT fk_projects_profile FOREIGN KEY (profile_id) REFERENCES profiles (id) ON DELETE CASCADE
);

-- ─── Clients ──────────────────────────────────────────────────────────────────

CREATE TABLE clients (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profile_id  BIGINT UNSIGNED NOT NULL,
    name        VARCHAR(255) NOT NULL,
    logo_url    VARCHAR(1000) NULL,
    website_url VARCHAR(1000) NULL,
    position    INT UNSIGNED NOT NULL DEFAULT 0,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT fk_clients_profile FOREIGN KEY (profile_id) REFERENCES profiles (id) ON DELETE CASCADE
);

-- ─── Skills / Expertise ───────────────────────────────────────────────────────

CREATE TABLE skills (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profile_id  BIGINT UNSIGNED NOT NULL,
    name        VARCHAR(255) NOT NULL,
    category    VARCHAR(255) NULL,
    position    INT UNSIGNED NOT NULL DEFAULT 0,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT fk_skills_profile FOREIGN KEY (profile_id) REFERENCES profiles (id) ON DELETE CASCADE
);

-- ─── Tools ────────────────────────────────────────────────────────────────────

CREATE TABLE tools (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profile_id  BIGINT UNSIGNED NOT NULL,
    name        VARCHAR(255) NOT NULL,
    category    VARCHAR(255) NULL,
    position    INT UNSIGNED NOT NULL DEFAULT 0,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT fk_tools_profile FOREIGN KEY (profile_id) REFERENCES profiles (id) ON DELETE CASCADE
);

-- ─── Satisfactions / Reviews ──────────────────────────────────────────────────

CREATE TABLE satisfactions (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profile_id  BIGINT UNSIGNED NOT NULL,
    author_name VARCHAR(255) NOT NULL,
    author_role VARCHAR(255) NULL,
    content     TEXT NOT NULL,
    rating      TINYINT UNSIGNED NULL,                       -- 1–5
    position    INT UNSIGNED NOT NULL DEFAULT 0,
    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT fk_satisfactions_profile FOREIGN KEY (profile_id) REFERENCES profiles (id) ON DELETE CASCADE
);

-- ─── Contact Messages ─────────────────────────────────────────────────────────
-- Messages sent by site visitors — NOT admin contact info.

CREATE TABLE contact_messages (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profile_id  BIGINT UNSIGNED NULL,

    -- Visitor details
    name        VARCHAR(255) NOT NULL,
    email       VARCHAR(255) NOT NULL,
    phone       VARCHAR(50)  NULL,
    subject     VARCHAR(255) NULL,
    message     TEXT         NOT NULL,

    -- Admin response
    reply       TEXT         NULL,
    is_read     TINYINT(1)   NOT NULL DEFAULT 0,
    replied_at  TIMESTAMP    NULL,

    created_at  TIMESTAMP NULL,
    updated_at  TIMESTAMP NULL,
    CONSTRAINT fk_contact_messages_profile FOREIGN KEY (profile_id) REFERENCES profiles (id) ON DELETE SET NULL
);

-- ─── Site Views / Analytics ───────────────────────────────────────────────────

CREATE TABLE site_views (
    id               BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    view_date        DATE         NOT NULL UNIQUE,
    page_views       INT UNSIGNED NOT NULL DEFAULT 0,
    clicks           INT UNSIGNED NOT NULL DEFAULT 0,
    resume_downloads INT UNSIGNED NOT NULL DEFAULT 0,
    created_at       TIMESTAMP NULL,
    updated_at       TIMESTAMP NULL
);
