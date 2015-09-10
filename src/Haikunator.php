<?php

namespace Atrox\Haikunator;

class Haikunator
{
    public static $ADJECTIVES = [
        "adorable",
        "aluminum",
        "ancient",
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
        "citrine",
        "clever",
        "cool",
        "copper",
        "crystal",
        "cyan",
        "delicate",
        "delightful",
        "elegant",
        "emerald",
        "fancy",
        "floral",
        "frosty",
        "gentle",
        "gifted",
        "glamorous",
        "golden",
        "gray",
        "green",
        "handsome",
        "helpful",
        "indigo",
        "intriguing",
        "jeweled",
        "jolly",
        "keen",
        "kind",
        "lively",
        "lucky",
        "magenta",
        "mauve",
        "melodic",
        "misty",
        "orange",
        "patient",
        "peachy",
        "periwinkle",
        "platinum",
        "polished",
        "proud",
        "quaint",
        "rapid",
        "royal",
        "shy",
        "silent",
        "silver",
        "snowy",
        "soft",
        "solitary",
        "sparkling",
        "still",
        "sweet",
        "tiny",
        "twilight",
        "ubiquitous",
        "unflappable",
        "utopian",
        "valiant",
        "verdant",
        "wandering",
        "warm",
        "weathered",
        "whispering",
        "wild",
        "wispy",
        "xanthous",
        "zany",
        "zesty",
        "zippy",
    ];

    public static $NOUNS = [
        "aardvark",
        "alpaca",
        "anaconda",
        "antlion",
        "basilisk",
        "beetle",
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
        "chinchilla",
        "chipmunk",
        "corgi",
        "condor",
        "coyote",
        "crane",
        "crocodile",
        "daffodil",
        "dalmation",
        "dandelion",
        "daschund",
        "dolphin",
        "dove",
        "eagle",
        "elephant",
        "elk",
        "falcon",
        "firefly",
        "flamingo",
        "fox",
        "frog",
        "gazelle",
        "gecko",
        "giraffe",
        "hedgehog",
        "hyacinth",
        "ibex",
        "jaguar",
        "kangaroo",
        "kiwi",
        "koala",
        "koi",
        "labrador",
        "ladybug",
        "lemur",
        "lilac",
        "lion",
        "llama",
        "lynx",
        "lyrebird",
        "macaw",
        "malamute",
        "mantis",
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
        "otter",
        "owl",
        "panda",
        "parrot",
        "penguin",
        "poodle",
        "quail",
        "raven",
        "rhinoceros",
        "salamander",
        "saguaro",
        "seahorse",
        "sparrow",
        "starling",
        "sunflower",
        "sycamore",
        "tapir",
        "tiger",
        "tulip",
        "turtle",
        "uguisu",
        "violet",
        "wallaby",
        "walrus",
        "whale",
        "wolf",
        "wren",
        "yak",
        "zebra",
    ];

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
