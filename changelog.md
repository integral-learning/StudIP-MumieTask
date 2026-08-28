# MumieTask - Changelog

All important changes to this plugin will be documented in this file.

## TODO
### Added
- The MUMIE pool/LMS-problem-selector URL is now configurable in the admin settings (previously hardcoded to https://pool.mumie.net)

### Changed
- Tightened the SSO token verification window from 1 hour to 60 seconds, matching the other LMS plugin implementations

### Fixed
- Grade sync for a whole course (e.g. opening the MUMIE-Task overview) hashed every user to the same broken value because `getAllUsers()` returned full DB rows instead of plain user ids
- `MumieServerInstance::fromURL()` triggered an undefined-property warning because it built a server object without a `name` property

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
