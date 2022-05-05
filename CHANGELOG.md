## [1.0.0] = 2022-05-05

### Added

- Remove old codebase
- Rewrite all codebase to pipelines and callables
- Rewrite tests
- All changes were made belongs to the issue #59

## [0.0.2] - 2022-04-26

### Added

- Basic Skeleton (#5)
- Module generator; (#31)
- Input validation (#37)
- Command generator #9 (#45)
- Entity generator (#10) and **Scope** (#48)

### Fixed

- Fix the blank line in templates if data doesn't exist in variable or is empty; (#33)
- The file writer should ask for file rewrite if it exists. (#34)
- Disable shared type for validators instead of factories usage. #38 (#39)

### Improved

- Create ComponentManager; Simplify constructors; Remove ValidatorResultBuilder; #46
- Basic tests (#32) & Improve writing tests #35 (#36)
- The stub writer improvement #49 (#50)
