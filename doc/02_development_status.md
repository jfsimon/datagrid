Development status
==================

Backlog
-------

- **done**: as a user I want to render a collection of strings (in-memory arrays) as an HTML table
- **done**: as a user I want to render a collection of mixed data (string, number, datetime) (in-memory arrays) as an HTML table
- **done**: as a user I want to get columns name in header
- **done**: as a user I want to automatically display CRUD links on each row
- **done**: as a user I want to translate columns label
- **done**: as a user I want to translate actions label
- **done**: as a user I want to use router for action links
- **wip**: as a user I want to have a full documentation of the component
- **todo**: as a user I want to add classes to HTML tags

Icebox
------

- as a user I want to use Doctrine as data source
- as a user I want to paginate results
- as a user I want to sort data by column names asc/desc
- as a user I want to filter string data with an input HTML tag using fuzzy match
- as a user I want to filter datetime data using datetime boundaries
- as a user I want to apply CRUD actions on multiple rows at the same time

Personal objectives
-------------------

- Create a well coded component using Domain Development Design.
- Make it highly extensible using open-close principle.
- Depend on strong libraries to keep code lightweight.
- Keep it open-source because I believe in it (license MIT).
- Cover 100% of code with tests.
- Keep as framework-agnostic as possible.

Personal todo list
------------------

- [x] Implement an AST with visitor capability
- [x] Implement an easy way to build data grids
- [x] Implement Twig renderer
- [x] Implement standard data formatters
- [x] Write some tests
- [x] Improve exceptions (classes & messages)
- [x] Implement a labels extension
- [x] Implement an actions extension
- [x] Add acceptance tests
- [x] Add translator support
- [ ] Add HTML class visitor
- [ ] Add sorting capability to labels
- [ ] Implement a debug extension
- [ ] Implement a Doctrine factory
- [ ] Handle multi-columns/multi rows cells
- [ ] Implement a filter extension
- [ ] Manage data querying (sorting, filtering)
- [ ] Think about grouping data rows


