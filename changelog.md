# MumieTask - Changelog

All important changes to this plugin will be documented in this file.

## TODO
### Added
- Admin-configurable MUMIE pool URL

### Changed
- Tightened the SSO token verification window from 1 hour to 60 seconds, matching the other LMS plugin implementations
- The task overview no longer syncs grades for every user on every visit; opening an individual task still syncs only your own grade for that task, and the grade overview still syncs everyone

### Fixed
- A MUMIE-Task page no longer loads a task belonging to a different course
- Broken grade sync for whole courses
- PHP warnings on the task overview, individual task and grade overview pages
- The problem selector no longer defaults to "ungraded" for a new task, hiding graded problems until one was picked
- Grades are no longer synced (and thus no longer visible to students) before a task's due date has passed
- The grade overview no longer shows a misleading "failed" icon for students who haven't been graded yet

### Removed
- Removed the admin option to share a user's first name, last name or e-mail address with MUMIE servers. No personal user data is sent for SSO anymore, only a pseudonymous user id.

## [v1.5] - 2021-10-22
### Added
- Ungraded MUMIE Tasks are now supported in Stud.IP. They represent ungraded links to MUMIE articles.
- MUMIE servers with multiple courses are now supported

## [V1.4] - 2021-06-30
### Fixed
- Fixed an error where control characters in server structure object were not properly escaped when encoding to json.

## [v1.3] - 2021-05-20
### Changed
- MUMIE Problems are now selected with a more advanced external problem browser

## [v1.2] - 2020-10-13
### Fixed
- Fixed a JavaScript error that disabled MUMIE Task form because of French translation in course.json

## [v1.1] - 2020-06-17
### Fixed
- Resolved issue that caused hashes to be identical for different users

### Added
- MUMIE course names are now available in multiple languages
- Teachers can now create MUMIE Tasks for LEMON servers
