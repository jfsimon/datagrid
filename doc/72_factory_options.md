Grid factory options
====================

Factory options depends on registered extension. The following extension are provided by default:

---

*  `core`: adds basic grid options

| Option | Default | Description |
|--------|---------|-------------|
| `schema` | `null` | a `Jfsimon\Datagrid\Model\Schema` instance |
| `name` | `'datagrid'` | a string representing the datagrid identifier |
| `caption` | `null` | a string to render as table caption, or `null` |

---

* `data`: builds the data rows accordingly to the schema

---

* `label`: adds a top label row

| Option | Default | Description |
|--------|---------|-------------|
| `label` | `true` | a boolean controlling the display of the labels row |
| `label_trans` | `Trans::disable()` | a `Jfsimon\Datagrid\Model\Trans` instance controlling labels translation |

---

* `actions`: permits to add a column containing actions links

| Option | Default | Description |
|--------|---------|-------------|
| `actions` | `Actions::disable()` | a `Jfsimon\Datagrid\Model\Actions` instance containing settings |
| `actions_trans` | `Trans::disable()` | a `Jfsimon\Datagrid\Model\Trans` instance controlling actions label translation |
