# Iterators Magic
Iterators magic is a way to iterate everything (folder - files - pdo vs.) with OOP structure.

Gives you, the separation of concerns and extendable class structure while you have an iterator with a renderer class.

Please don't hesitate to contribute if you have different opinion that you want to share.

<h2>Usage</h2>

You can use any <strong>renderer</strong> class to render result of the Iteration class ( SPL class )

There is an example in project that called HtmlDirectoryRenderer to print the results to a page with html design.

<pre>
$data = new HtmlDirectoryRenderer(
    new LocalDirectoryIterator('/var/www')
);

$data->render();
</pre>

<strong>Iterator Class use IteratorAggregate interface and getIterator() method for iteration.</strong>

You can change easily DirectoryIterator and Renderer Type. 

For example if you want to iterate a remote directory folder with a ftp connection,

You can create a class FtpDirectoryIterator : 

You can pass configuration with AbstractDirectoryIterator to your main Iterator class.

<pre>
$data = new HtmlDirectoryRenderer(
    new FtpDirectoryIterator('/var/www',$config)
);

$data->render();
</pre>
<strong>TreeIterator</strong>

TreeIterator example of view folder structure as tree view.
<pre>
[tree]
├ /var/www/playground/app
├ /var/www/playground/package.json
├ /var/www/playground/gulpfile.js
├ /var/www/playground/.git
├ /var/www/playground/config.js
├ /var/www/playground/.babelrc
├ /var/www/playground/readme.md
├ /var/www/playground/.gitignore
├ /var/www/playground/merger
├ /var/www/playground/public
└ /var/www/playground/.idea
</pre>
<h2>Filters</h2>
You can define filters to filter your iteration. You can create custom filter easily in your Filter class and you can just define with an array. 

<pre>
$filters = [
    [
        'filter'=>'extension',
        'extensions'=>['php', 'html', 'js', 'tpl']
    ],
    [
        'filter'=>'search_in_file',
        'needle'=>'youtube'
    ]
];

$data = new HtmlDirectoryRenderer(
    new LocalDirectoryIterator('/var/www/playground'),
    $filters
);

$data->render();
</pre>

<strong>Filters must return SPL directory File Info ( $this->directory ) or false (break out filter queue)</strong>
<pre>

protected function ExtensionFilter($filter)
{
    $extensions = $filter['extensions'];

    return in_array($this->directory->getExtension(), $extensions) === true?$this->directory:false;
}
</pre>