# Table of contents

1. Preface
2. Style guide
    1. Basic styling
        1. PSR-compliant style
        2. Comments and PHPDoc
        3. Unwanted operators
        4. Class and method length limitations
        5. Collection styling
        6. String literals
        7. Indentation
        8. Working with IDEs
    2. Calls to Laravel and Eloquent
        1. Beware of facades
        2. Beware of static model calls
        3. Handling of SRP violations in Eloquent
    3. Styling of unit tests
        1. setUp() method
        2. Separation of mocks
        3. Using callbacks for mocked methods
    4. Naming conventions
    5. New features of PHP 7
3. Coding guide
    1. Controllers
    2. Models and repositories
        1. Separation of repository code from models
        2. Separation of business logic from models and repositories
    3. Services
        1. SOA principles
        2. Service hierarchies
    4. Factories
    5. Structs and associative arrays
        1. Associative arrays are dangerous
        2. Defining structs
        3. Getters and setters
    6. Static classes
    7. Third-party code
    8. Exceptions
    9. Miscellaneous
4. Testing guide
    1. Unit testing
        1. What must be tested in unit test?
        2. Mockable and non-mockable classes
        3. Test wrappers
        4. Test cases
    2. API testing
        1. What must be tested in API test?
        2. Working with the DB and cleaning up
5. Swagger documentation
6. DB guide
    1. General information
    2. Table and column definitions
    3. Queries
7. Frontend / Javascript guide
    1. Styling
        1. Sources of truth for JS styling
        2. Constants and symbols
        3. Length limitations
        4. Unwanted operators and expressions
        5. Privacy emulation
        6. Directory structure and file naming conventions
    2. Coding
        1. Components
        2. Mixins and watchers
        3. Services
        4. Templates
        5. Vuex modules
        6. Promises
        7. Third-party packages
    3. JS tests
        1. What should be tested
        2. Writing unit tests
        3. Writing browser tests
    4. HTML and CSS
        1. HTML style guide
        2. Vue-specific HTML
        3. CSS and SASS
8. Git and Jira guide
    1. Creating and managing Jira issues
    2. Git branches and pull requests
        1. Branch and commit naming
        2. Pull requests
        3. Code reviews
        4. Merging
        5. Rules for bugfixes and hotfixes
        6. Rules for Wiki changes
    3. Monorepo guide
9. Acceptance testing guide
    1. Testing workflow
    2. What to test and what not to test
    3. Writing Gherkin
    4. Writing context classes
        1. General rules
        2. Given, When and Then methods
        3. Lifestyle hooks
        4. Main context and base context
    5. Running tests
    6. Handling volatility
