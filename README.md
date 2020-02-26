# Twig Helpers

## Installation

`composer require dmt-software/twig-helpers`

## Usage

### Tabular

First create a template that will render the tabular data. 
The following snippet shows an example of a twig template.
```twig
{# file: example.twig #}
{% import 'theme/tabular/default-table.twig' as tab %}
 
{{ tab.tabular_start(table) }}
    {{ tab.header_row(table.columns) }}
    {{ tab.data_rows(table.resultSet, table.columns) }}
{{ tab.tabular_close() }}
```
In php create a table using the tabular builder, add a result set to it and render the template.
```php
<?php
 
use DMT\Twig\Tabular\Builder;
use Twig\Environment;
 
$table = (new Builder())
    ->addColumn('id', '#')
    ->addColumn('username', 'name')
    ->addColumn('email')
    ->build();

/** @var iterable $tabularData */
$table->setResultSet($tabularData);
 
/** @var Environment $twig */
print $twig->render('example.twig', compact('table'));
```
The output will look like the code below.
```html
<table>
    <thead>
        <tr>
            <th>#</th><th>name</th><th>email</th>        
        </tr>    
    </thead>
    <tbody>
        <tr>
            <td>1</td><td>admin</td><td>user@example.dev</td>        
        </tr>
        ...
        <tr>
            <td>99</td><td>zzz</td><td>disabled@no-spam.com</td>        
        </tr>    
    </tbody>
</table>
```
more [documentation](docs/tabular.md) on tabular configuration and usage.
