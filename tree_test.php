<html><head><title>Unit test for Element and Tree</title></head>
<style>
.pass {color:green;}
.fail {color:red;}
</style>
<body>
<?php

require_once "treebuilder.php";
$i = 0;
test1();
test2();
exit;
 
function  test1() {
    global $i;
    print "\n<br><br>Element tests: ";
    $node = new Element("div");
    $node->attr['id'] = 'test_id';
    $node->push_content('Hello world');
    print "\n<br>test".++$i." (Element) : ";
    print result($node == '<div id="test_id">Hello world</div>');
    
    print "\n<br>test".++$i." (Element->tag()) : ";
    $check1 = ($node->tag() == 'div');
    $node->tag('span');
    $check2 = ($node->tag() == 'span');
    print result($check1 and $check2);
    
    print "\n<br>test".++$i." (Element->attr()) : ";
    $check1 = ($node->attr('id') == 'test_id');
    $node->attr('id', 'test_id_2');
    $check2 = ($node->attr('id') == 'test_id_2');
    print result($check1 and $check2);
    
    print "\n<br>test".++$i." (Element->push_content()) : ";
    $node2 = new Element("div");
    $node2->push_content('Here comes the first node:', $node);
    $node->attr('id', 'test_id');
    $check1 = ($node2 == '<div>Here comes the first node:<span id="test_id">Hello world</span></div>');
    $check2 = ($node->parent === $node2);
    print result($check1 and $check2);
    
    print "\n<br>test".++$i." (Element->as_text()): ";
    $text = $node2->as_text();
    print result($text == 'Here comes the first node:Hello world');
    
    print "\n<br>test".++$i." (Element->detach()) : ";
    $node->detach();
    $check1 = ($node2 == '<div>Here comes the first node:</div>');
    $check2 = ($node == '<span id="test_id">Hello world</span>');
    $check3 = (!$node->parent);
    print result($check1 and $check2 and $check3);

    print "\n<br>test".++$i." (Element->unshift_content()) : ";
    $node2->unshift_content($node);
    $node->attr('id', 'test_id_3');
    $check1 = ($node2 == '<div><span id="test_id_3">Hello world</span>Here comes the first node:</div>');
    $check2 = ($node->parent === $node2);
    print result($check1 and $check2);
    
    print "\n<br>test".++$i." (Element->preinsert()) : ";
    $node3 = new Element('img');
    $node3->attr('src', 'http://www.google.com/intl/en_ALL/images/logo.gif');
    $node->preinsert('an image', $node3);
    $check1 = ($node2 == '<div>an image<img src="http://www.google.com/intl/en_ALL/images/logo.gif" /><span id="test_id_3">Hello world</span>Here comes the first node:</div>');
    $check2 = ($node3->parent === $node2);
    $check3 = ($node->parent === $node2);
    print result($check1 and $check2 and $check3);
    
    print "\n<br>test".++$i." (Element->postinsert()) : ";
    $node3->detach();
    $node->postinsert($node3);
    $check1 = ($node2 == '<div>an image<span id="test_id_3">Hello world</span><img src="http://www.google.com/intl/en_ALL/images/logo.gif" />Here comes the first node:</div>');
    $check2 = ($node3->parent === $node2);
    print result($check1 and $check2);

    print "\n<br>test".++$i." (Element->look_down()) : ";
    $check1 = (!$node2->look_down(array('_tag' => 'a')));
    $check2 = ($node2->look_down(array('_tag' => 'span')) === $node);
    $check3 = ($node2->look_down(array('src' => 'http://www.google.com/intl/en_ALL/images/logo.gif')) === $node3);
    print result($check1 and $check2 and $check3);

}

function test2() {
    print "\n<br><br>Tree tests: ";
    $test_array = array(
        'basic HTML' => array('<div>Hello world</div>', '<div>Hello world</div>'),
        'malformed attr1' => array('<span ="foo">Hello world</span>', '<span>Hello world</span>'),
        'malformed attr2' => array('<span "foo">Hello world</span>', '<span foo="">Hello world</span>'),
        'malformed attr3' => array('<span "foo>Hello world</span>', '<span foo="">Hello world</span>'),
        'nested elements' => array('<div class="myclass">hello <span class="myclass">world!</span> <span class="class2"><a href="google.com"><img src="http://www.google.com/intl/en_ALL/images/logo.gif" /></a></span></div>', '<div class="myclass">hello <span class="myclass">world!</span> <span class="class2"><a href="google.com"><img src="http://www.google.com/intl/en_ALL/images/logo.gif" /></a></span></div>'),
        'missing leading tag' => array('Hello world</li>', '<li>Hello world</li>'),
        'non-closed HTML comment' => array('Hello<!-- should not be separate node world', 'Hello<!-- should not be separate node world-->'),
        'self-closing tags' => array('<div><span id="myid" />blabla<span>dekjf</span></div>', '<div><span id="myid" />blabla<span>dekjf</span></div>'),
        'script should not be self-closing' => array('<table id="mytable"><tr><script src="foo.js" /></table>', '<table id="mytable"><tr><script src="foo.js"></script></tr></table>'),
        '<script> closed by </SCRIPT>' => array('<div>test<script>var a="Hello <b>world</b>";alert(a);</SCRIPT></div>', '<div>test<script>var a="Hello <b>world</b>";alert(a);</script></div>'),
        'converting single quotes to double' => array('<div><span onclick=\'alert("Hello!");\'>Hello world</span></div>', '<div><span onclick="alert(&quot;Hello!&quot;);">Hello world</span></div>'),
        'implicit tag close' => array('<div><span>Hello world</div>', '<div><span>Hello world</span></div>'),
        'implicit tag close1' => array('<font>Hello<div> world</div>', '<font>Hello</font><div> world</div>'),
        'implicit tag open' => array('<table><td>hello world</tr></table>', '<table><tr><td>hello world</td></tr></table>'),
        'multiple attributes' => array('<meta_test http-equiv="Content-Type" content="text/html; charset=iso-8859-1">', '<meta_test http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />'), // meta tag is head specific and will cause generation of html/head structure
        'test for comments handling' => array('<div><div><!--a_comment--><div><div><!--another_comment--></div></div></div></div>', '<div><div><!--a_comment--><div><div><!--another_comment--></div></div></div></div>'),
        'empty divs' => array('<div id="myid">hello <div></div> world</div>', '<div id="myid">hello <div></div> world</div>'),
        'missed &gt;' => array('<tr <td>hello world</td></tr>', '<tr><td>hello world</td></tr>'),
        'blank document' => array('', ''),
    );
    $tree= new Tree;
    foreach ($test_array as $test_name=>$test) {
        $tree->parse_content($test[0]);
        print htmlentities($test_name).": ".result($test[1] == $tree)."\n<br>";
        if ($test[1] != $tree) {
            echo htmlentities($test[1])."\n<br>".htmlentities($tree)."\n<br>";
        }
    }

    print "\n<br>test (Tree->look_down()) : ";
    $tree->parse_content($test_array['nested elements'][0]);
    $check1 = ($tree->look_down(array('_tag'=>'span', 'class'=>'myclass')) == '<span class="myclass">world!</span>' );
    result($check1);
    
}

function result($result) {
    return "<b class='".($result ? "pass" : "fail")."'>".($result ? "Pass" : "Fail")."</b>";
}
?></body></html>