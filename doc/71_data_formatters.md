Data formatters reference
=========================

When building the datagrid [schema](11_display_a_data_table.md), you pass a *data formatter* identifier as column type.
Each formatter accept specific options. Of course, these options are merged with common column options.

---

* `boolean`: formats a boolean value

| Option | Default | Description |
|--------|---------|-------------|
| `true_value` | `'yes'` | a string to display if value is `true` |
| `false_value` | `'no'` | a string to display if value is `false` |

---

* `datetime`: formats `\DateTime` objects

| Option | Default | Description |
|--------|---------|-------------|
| `null_value` | `''` | a string to display if value is `null` |
| `date_format` | `\IntlDateFormatter::MEDIUM` | an `\IntlDateFormatter` constant for date formatting |
| `time_format` | `\IntlDateFormatter::SHORT` | an `\IntlDateFormatter` constant for time formatting |
| `time_zone` | `null` | a string representing the time zeone |
| `calendar` | `\IntlDateFormatter::GREGORIAN` | an `\IntlDateFormatter` constant representing used calendar |
| `pattern` | `null` | a string representing the format pattern |

---

* `label`: formats a label, this formatter is used internally for label cells

---

* `number`: formats a number (integer or float)

| Option | Default | Description |
|--------|---------|-------------|
| `null_value` | `''` | a string to display if value is `null` |
| `precision` | `null` | a valid `\NumberFormatter` attribute value |
| `rounding_mode` | `null` | a valid `\NumberFormatter` attribute value |
| `grouping` | `null` | a valid `\NumberFormatter` attribute value |

---

* `string`: formats a string

| Option | Default | Description |
|--------|---------|-------------|
| `null_value` | `''` | a string to display if value is `null` |
