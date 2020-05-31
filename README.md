# PHP-DataTemplate
A lightweight library for rendering HTML templates in a clean way.

## Installation

Either install via Composer or download this repository and include the class in your project manually.

## Usage

The template takes a HTML file and a PHP array as inputs, and works by replacing strings inside the defined template tags with data from the input array with the same key. For example, `{{email}}` will be replaced by the contents of `$data['email']`.

### Initialization

The constructor accepts 3 arguments: The name of the template file to use, the root path of the template directory (optional, default: `'./templates'`) and an array of opening and closing tags to fill in your template (optional, defaults to `['{{','}}'}`).

```(php)

$template = 'item.html';
$baseDir = dirname(__FILE__).'/tpl';
$template = new DataTemplate($template, $baseDir);
```

### Rendering a template

Once your instance is ready, you can call the `render()` method, passing in the data to be rendered as argument. 

```(php)
$data = [
  'foo' => 'hello',
  'bar' => 'world'
];
$template = new DataTemplate($template, $baseDir);
$html = $template->render($data);
```

#### Nested templates

To nest templates inside other templates, simply put the name of the template inside the template tags. For example, `{{partial.html}}` will render the contents of `partial.html` to replace the tag. 

#### Repeating templates

To repeat a partial template, simply prefix it with a `*` and pass an array as its value inside `$data`. For example, `{{*item.html}}` will render the contents of `item.html` as many times as there are elements in the `$data['item.html']` array.

```(php)
