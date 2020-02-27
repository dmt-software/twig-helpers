# Tabular

## Usage in templates

### Select a theme
 
Depending on your needs, a specific template can be selected for your tabular 
display. Some predefined display themes are store in the `theme/tabular/` 
folder. To use them you _import_ them inside your template.

```twig
{% import 'theme/tabular/bootstrap-4-table.twig' as tab %}
```

### Show reoccurring header row

When dealing with a result set that contains a lot of rows, you might choose to
show the header row after a certain amount of rows. This way the end-user will
be remembered what the columns contain without scrolling (back) to the top. To
enable this reoccurring header, the _data_rows_ macro accepts a third argument
that tells the amount of rows that have to pass until a column header row is 
displayed again.

```twig
{{ data_rows(form.resultSet, form.columns, 50) }} 
```    

### Create your own theme template

You can create your own theme template that holds a specific tabular design
implementation. You even can extend your theme from one of the existing ones.
Your template should (after extension) contain the following macros:
 * tabular_open - To start the tabular
 * header_row - To display the column headings
 * header_simple - To display a plain heading row   
 * data_rows - To iterate through the result set
 * data_row - To display one single row
 * tabular_close - To end the opened tabular

> NOTE: macros that include other macros will always use the macro within the
> file they are at and not the original child template that included them. To 
> override the _data_row_ the _data_rows_ must be inside the child template 
> or else the _data_row_ within the parent is used. 


## Column definitions

When creating a table using tabular each element in the row of the result set
that you want to display must be defined as a column. This way you can decide
what columns you want and what you don't want to show the end-user.     

### Add styling to a table column

To change the display of the contents of a table cell, you can define a class
in your stylesheets and add that to the column definition. 

```php
use DMT\Twig\Tabular\Builder;
 
$class = 'right'; // or an array for multiple classes

/** @var Builder $builder */
$builder->addColumn('score', 'test score', compact('class'));
```
### Adding a sortable column

To enable sorting you first must create or use an object that contains the link 
building strategy. Without this _metadata object_ you can not add sortable 
columns.

```php
use DMT\Twig\Tabular\Builder; 
use DMT\Twig\Tabular\MetadataInterface;
 
/** @var MetadataInterface $metadata */ 
$table = (new Builder())
    ->withMetadata($metadata)
    ->addSortableColumn('username', 'name')
    ->build();
```   

### Adding a custom column

Custom columns are the way of combining values from a row, adding table cells
that are not present in the original result set, or manipulate or decorate data
from the incoming row.     
 
The following example will load and renders a template with the current row and
the column data.
```php
use DMT\Twig\Tabular\Builder;
use Twig\Environment;
 
/** @var Environment $twig */
$table = (new Builder())
    ->addColumn('id', '#')
    ->addColumn('username', 'name')
    ->addCustomColumn('email', function ($row) use ($twig) {
        return $twig->render('email-field.twig', ['email' => $row->email]);
    })
    ->build();
```
> Custom columns are defined by using a _\Closure_. This closure excepts the 
> current row is bound to the column it is defined in.  
 