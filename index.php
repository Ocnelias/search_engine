<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// abstract factory
interface Invokable
{
    function createSearchKeywords();

}

//  implementation of cyryllic search
class CyrillicEngine implements Invokable
{

    // create keywords from cyrillic string
    public function createSearchKeywords()
    {
        return new CyrillicList;
    }


}

//  implementation of english search
class EnglishEngine implements Invokable
{

    // create keywords from cyrillic string
    public function createSearchKeywords()
    {
        return new EnglishList;
    }


}


// operations on given search string
class CyrillicList
{


    public function stopWords($query)
    {

        $reg = "/под|много|что|когда|где|или|которые|поэтому|все|будем|как/i"; //cut off all stop words
        $query = preg_replace($reg, '', $query); //remove stop words
        return $query;
    }


    public function dropBackWords($word)
    {
        //тут мы обрабатываем одно слово
        $reg = "/(ый|ой|ая|ое|ые|ому|а|о|у|е|ого|ему|и|ство|ых|ох|ия|ий|ь|я|он|ют|ат)$/i"; //This regular function will look for matching endings
        $word = preg_replace($reg, '', $word); //remove endings
        return $word;
    }

    public function convert($query)
    {


        $query = $this->stopWords($query);    //use the function  wrote earlier to remove stop words
        $query= preg_replace('/[^\p{L}\p{N}\s]/u', '', $query);
        $words = explode(" ", $query);
        $i = 0;
        $keywords = "";
        foreach ($words as $word) {
            $word = trim($word);
            if (strlen($word) < 6) {        //if the word is shorter than 6 characters then delete it
                unset($word);
            } else {
                if (strlen($word) > 8) {
                    $keywords[$i] = $this->dropBackWords($word);    // end cleansing function for words longer than 8 characters and entering them into the array we created
                    $i++;
                } else {
                    $keywords[$i] = $word;
                    $i++;
                }
            }
        }
        return $keywords;


    }
}


// operations on given search string
class EnglishList
{


    public function stopWords($query)
    {

        $reg = "/
a|
about|
above|
after|
again|
against|
all|
am|
an|
and|
any|
are|
aren't|
as|
at|
be|
because|
been|
before|
being|
below|
between|
both|
but|
by|
can't|
cannot|
could|
couldn't|
did|
didn't|
do|
does|
doesn't|
doing|
don't|
down|
during|
each|
few|
for|
from|
further|
had|
hadn't|
has|
hasn't|
have|
haven't|
having|
he|
he'd|
he'll|
he's|
her|
here|
here's|
hers|
herself|
him|
himself|
his|
how|
how's|
i|
i'd|
i'll|
i'm|
than|
that|
that's|
the|
their|
theirs|
them|
themselv|es
then|
there|
there's|
these|
they|
they'd|
they'll|
they're|
they've|
this|
those|
through|
to|
too|
under|
until|
up|
very|
was|
wasn't|
we|
we'd|
we'll|
we're|
we've|
were|
weren't|
what|
what's|
when|
when's|
where|
where's|
which|
while|
who|
who's|
whom|
why|
why's|
with|
won't|
would|
wouldn't|
you|
you'd|
you'll|
you're|
you've|
your|
yours|
yourself|
yourselves/i"; //cut off all stop words
        $query = preg_replace($reg, '', $query); //remove stop words
        return $query;
    }


    public function convert($query)
    {


        $query = $this->stopWords($query);    //use the function  wrote earlier to remove stop words
        $query= preg_replace('/[^\p{L}\p{N}\s]/u', '', $query);
        $words = explode(" ", $query);
        $i = 0;
        $keywords = "";
        foreach ($words as $word) {
            $word = trim($word);
            if (strlen($word) < 4) {        //if the word is shorter than 6 characters then delete it
                unset($word);
            } else {
                if (strlen($word) > 6) {
                    $keywords[$i] =$word;    // end cleansing function for words longer than 8 characters and entering them into the array we created
                    $i++;
                } else {
                    $keywords[$i] = $word;
                    $i++;
                }
            }
        }
        return $keywords;


    }
}






$factory = new CyrillicEngine;
$search = $factory->createSearchKeywords();
print_r($search->convert('как и где создать правильный, поисковой запрос?'));


$factory = new EnglishEngine();
$search_eng = $factory->createSearchKeywords();
print_r($search_eng->convert('how to create, search query?'));

?>