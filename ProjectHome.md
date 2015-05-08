it's more a try to get more reliable parser than the simple HTML DOM parser and more mature when it comes to really bad HTML.<br>
<br>
It uses a syntax close to Perl HTML::Treebuilder.<br>
<br>
How to use:<br>
<pre><code>require_once('treebuilder.php');

$mytree = new Tree();
$mytree-&gt;parse_content('&amp;lt;div&amp;gt;Hello world&amp;lt;/div&amp;gt;');
// or
$mytree-&gt;parse_file('http://www.google.com');
$mytree-&gt;parse_file('myfile.htm');

// To print HTML, just do:
echo $mytree;

// For those of you who familiar with HTML::Treebuilder, usage is almost the same. Implemented methods:

 // same as HTML::Element
Element-&gt;attr($attr, $value = null);
Element-&gt;tag($tag = null);
Element-&gt;look_down($keys);
Element-&gt;traverse($callback, $text_only=false);
Element-&gt;push_content($test_or_node, ..);
Element-&gt;unshift_content($test_or_node, ..);
Element-&gt;detach();
Element-&gt;preinsert($test_or_node, ..);
Element-&gt;postinsert($test_or_node, ..);
Element-&gt;right(); // returns right sibling if any
Element-&gt;left(); // returns left sibling if any
Element-&gt;pindex(); // returns index in parent's children array
Element-&gt;detach_content(); //detaches all children nodes and returns them
Element-&gt;detach_content(); //deletes all children nodes and returns self
Element-&gt;as_HTML();
Element-&gt;as_text();
// plus one additional method:
Element-&gt;seek_n_destroy($keys); // same as look_down()-&gt;__destruct();

// same as HTML::Treebuilder:
Tree-&gt;parse_content($content);
Tree-&gt;parse_file($filename_or_url);
</code></pre>