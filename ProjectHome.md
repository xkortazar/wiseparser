it's more a try to get more reliable parser than the simple HTML DOM parser and more mature when it comes to really bad HTML.<br>
<br>
It uses a syntax close to Perl HTML::Treebuilder.<br>
<br>
How to use:<br>
<pre><code>require_once('treebuilder.php');<br>
<br>
$mytree = new Tree();<br>
$mytree-&gt;parse_content('&amp;lt;div&amp;gt;Hello world&amp;lt;/div&amp;gt;');<br>
// or<br>
$mytree-&gt;parse_file('http://www.google.com');<br>
$mytree-&gt;parse_file('myfile.htm');<br>
<br>
// To print HTML, just do:<br>
echo $mytree;<br>
<br>
// For those of you who familiar with HTML::Treebuilder, usage is almost the same. Implemented methods:<br>
<br>
 // same as HTML::Element<br>
Element-&gt;attr($attr, $value = null);<br>
Element-&gt;tag($tag = null);<br>
Element-&gt;look_down($keys);<br>
Element-&gt;traverse($callback, $text_only=false);<br>
Element-&gt;push_content($test_or_node, ..);<br>
Element-&gt;unshift_content($test_or_node, ..);<br>
Element-&gt;detach();<br>
Element-&gt;preinsert($test_or_node, ..);<br>
Element-&gt;postinsert($test_or_node, ..);<br>
Element-&gt;right(); // returns right sibling if any<br>
Element-&gt;left(); // returns left sibling if any<br>
Element-&gt;pindex(); // returns index in parent's children array<br>
Element-&gt;detach_content(); //detaches all children nodes and returns them<br>
Element-&gt;detach_content(); //deletes all children nodes and returns self<br>
Element-&gt;as_HTML();<br>
Element-&gt;as_text();<br>
// plus one additional method:<br>
Element-&gt;seek_n_destroy($keys); // same as look_down()-&gt;__destruct();<br>
<br>
// same as HTML::Treebuilder:<br>
Tree-&gt;parse_content($content);<br>
Tree-&gt;parse_file($filename_or_url);<br>
</code></pre>