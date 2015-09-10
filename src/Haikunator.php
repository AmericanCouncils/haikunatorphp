<?php

namespace Atrox\Haikunator;

class Haikunator
{
    public static $ADJECTIVES = [
        "accomplished",
        "adorable",
        "adventurous",
        "affable",
        "agreeable",
        "aluminum",
        "ambitious",
        "amiable",
        "ancient",
        "athletic",
        "azure",
        "billowing",
        "blue",
        "bold",
        "brave",
        "brilliant",
        "bubbly",
        "calm",
        "careful",
        "cerulean",
        "charismatic",
        "charming",
        "citrine",
        "classy",
        "clever",
        "compassionate",
        "considerate",
        "contemplative",
        "cool",
        "copper",
        "courageous",
        "crystal",
        "cyan",
        "decisive",
        "decorous",
        "delicate",
        "diligent",
        "dynamic",
        "elated",
        "elegant",
        "emerald",
        "entertaining",
        "exceptional",
        "exuberant",
        "fancy",
        "fearless",
        "floral",
        "friendly",
        "frosty",
        "fuzzy",
        "gallant",
        "gentle",
        "gifted",
        "glamorous",
        "golden",
        "gray",
        "green",
        "gregarious",
        "handsome",
        "helpful",
        "honest",
        "indigo",
        "intrepid",
        "intriguing",
        "jasper",
        "jeweled",
        "jolly",
        "keen",
        "kind",
        "literate",
        "lively",
        "lucky",
        "magenta",
        "mauve",
        "mellow",
        "melodic",
        "misty",
        "modest",
        "optimistic",
        "orange",
        "patient",
        "peachy",
        "periwinkle",
        "platinum",
        "plucky",
        "polished",
        "posh",
        "practical",
        "proud",
        "puce",
        "quaint",
        "quixotic",
        "rapid",
        "reliable",
        "resourceful",
        "royal",
        "sensible",
        "shy",
        "silent",
        "silver",
        "smart",
        "snowy",
        "soft",
        "solitary",
        "sparkling",
        "stalwart",
        "still",
        "sweet",
        "tidy",
        "twilight",
        "ubiquitous",
        "unflappable",
        "utopian",
        "valiant",
        "verdant",
        "vermillion",
        "versatile",
        "wandering",
        "warm",
        "weathered",
        "whispering",
        "wild",
        "wispy",
        "witty",
        "xanthous",
        "zany",
        "zesty",
        "zippy",
    ];

    public static $NOUNS = [
        "aardvark",
        "acacia",
        "alpaca",
        "anaconda",
        "antlion",
        "aphid",
        "armadillo",
        "aspen",
        "barracuda",
        "basilisk",
        "beetle",
        "birch",
        "bison",
        "bobcat",
        "bonobo",
        "butterfly",
        "camel",
        "capybara",
        "cardinal",
        "caribou",
        "caterpillar",
        "catfish",
        "chameleon",
        "cheetah",
        "chickadee",
        "chinchilla",
        "chipmunk",
        "condor",
        "corgi",
        "coyote",
        "crane",
        "crocodile",
        "cypress",
        "daffodil",
        "daisy",
        "dalmation",
        "dandelion",
        "daschund",
        "dolphin",
        "dove",
        "dragonfly",
        "eagle",
        "echidna",
        "elephant",
        "elk",
        "falcon",
        "firefly",
        "flamingo",
        "flax",
        "fox",
        "frog",
        "gazelle",
        "gecko",
        "gibbon",
        "giraffe",
        "hedgehog",
        "heron",
        "hyacinth",
        "ibex",
        "jaguar",
        "juniper",
        "kangaroo",
        "kiwi",
        "koala",
        "koi",
        "labrador",
        "ladybug",
        "larch",
        "lemur",
        "lilac",
        "lion",
        "llama",
        "lynx",
        "lyrebird",
        "macaw",
        "maize",
        "malamute",
        "mallard",
        "mantis",
        "maple",
        "marigold",
        "marlin",
        "mesquite",
        "mockingbird",
        "moose",
        "moth",
        "mouse",
        "narwhal",
        "newt",
        "ocelot",
        "olive",
        "otter",
        "owl",
        "panda",
        "parrot",
        "penguin",
        "pistachio",
        "playtpus",
        "poodle",
        "quail",
        "raspberry",
        "raven",
        "rhinoceros",
        "saguaro",
        "salamander",
        "saskatoon",
        "seahorse",
        "sparrow",
        "spruce",
        "starling",
        "stork",
        "sunflower",
        "sycamore",
        "tapir",
        "tarsier",
        "tiger",
        "tulip",
        "turtle",
        "uguisu",
        "violet",
        "wallaby",
        "walrus",
        "whale",
        "willow",
        "wolf",
        "wren",
        "yak",
        "zebra",
    ];

    public static function possibleCombos()
    {
        return count(self::$ADJECTIVES) * count(self::$NOUNS);
    }

    private static function feistelFunc($n, $k)
    {
        return (($n + $n + 1234) * $k) % 128;
    }

    public static function indexToScramble($i, $k = 5678)
    {
        $i %= (128*128);
        $a1 = ($i >> 7) % 128;
        $b1 = $i % 128;
        $a2 = $b1;
        $b2 = $a1 ^ self::feistelFunc($b1, $k);
        $a3 = $b2;
        $b3 = $a2 ^ self::feistelFunc($b2, $k);
        return ($a3 << 7) | $b3;
    }

    public static function scrambleToIndex($s, $k = 5678)
    {
        $a = $s >> 7;
        $b = $s % 128;
        $flipped = ($b << 7) | $a;
        $r = self::indexToScramble($flipped, $k);
        $a = $r >> 7;
        $b = $r % 128;
        return ($b << 7) | $a;
    }

    public static function scrambleToHaikuPair($s)
    {
        $a = ($s >> 7) % 128;
        $b = $s % 128;
        return [self::$ADJECTIVES[$a], self::$NOUNS[$b]];
    }

    private static function binsearch($needle, $haystack)
    {
        $high = count($haystack);
        $low = 0;

        while ($high - $low > 1){
            $probe = ($high + $low) / 2;
            if ($haystack[$probe] < $needle){
                $low = $probe;
            }else{
                $high = $probe;
            }
        }

        if ($high == count($haystack) || $haystack[$high] != $needle) {
            return false;
        } else {
            return $high;
        }
    }

    public static function haikuPairToScramble($adj, $noun)
    {
        $a = self::binsearch($adj, self::$ADJECTIVES);
        if ($a === false) { return false; }
        $b = self::binsearch($noun, self::$NOUNS);
        if ($b === false) { return false; }
        return ($a << 7) | $b;
    }

    public static function indexToHaikuPair($i, $k = 5678)
    {
        return self::scrambleToHaikuPair(self::indexToScramble($i, $k));
    }

    public static function haikuPairToIndex($adj, $noun, $k = 5678)
    {
        return self::scrambleToIndex(self::haikuPairToScramble($adj, $noun), $k);
    }

    /**
     * Generate Heroku-like random names to use in your applications.
     * @param array $params
     * @return string
     */
    public static function haikunate(array $params = array())
    {
        $defaults = [
            "delimiter" => "-",
            "tokenLength" => 4,
            "tokenHex" => false,
            "tokenChars" => "0123456789",
        ];

        $params = array_merge($defaults, $params);

        if ($params["tokenHex"] == true) $params["tokenChars"] = "0123456789abcdef";

        $adjective = self::$ADJECTIVES[mt_rand(0, count(self::$ADJECTIVES) - 1)];
        $noun = self::$NOUNS[mt_rand(0, count(self::$NOUNS) - 1)];
        $token = "";

        for($i = 0; $i <= $params["tokenLength"] - 1; $i++)
        {
            $token .= $params["tokenChars"][mt_rand(0, strlen($params["tokenChars"])-1)];
        }

        $sections = [$adjective, $noun, $token];
        return implode($params["delimiter"], array_filter($sections));
    }
}
