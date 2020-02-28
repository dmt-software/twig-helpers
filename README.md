# Twig Helpers

## Installation

`composer require dmt-software/twig-helpers`

## Usage

### Tabular

First create a template that will render the tabular data. The following 
snippet shows an example of a twig template.
```twig
{% import 'theme/tabular/default-table.twig' as tab %}
 
{{ tab.tabular_start(table) }}
    {{ tab.header_row(table.columns) }}
    {{ tab.data_rows(table.resultSet, table.columns) }}
{{ tab.tabular_close() }}
```
In php create a table using the tabular builder, add a result set to it and 
render the template.
```php
use DMT\Twig\Tabular\Builder;
use Twig\Environment;
 
$table = (new Builder())
    ->addColumn('id', '#')
    ->addColumn('username', 'name')
    ->addColumn('email')
    ->build();

/** @var iterable $userList */
$table->setResultSet($userList);
 
/** @var Environment $twig */
print $twig->render('example.twig', compact('table'));
```
This will render a html table for the _$userList_.

> More [documentation](docs/tabular.md) on tabular configuration and usage.
