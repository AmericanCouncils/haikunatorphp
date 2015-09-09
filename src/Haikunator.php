<?php

namespace Atrox\Haikunator;

class Haikunator
{
    public static $ADJECTIVES = [
        "misty", "silent", "dry", "dark", "warm", "delightful", "eager", "helpful",
        "icy", "delicate", "quiet", "cool", "silly", "clever", "gifted", "careful",
        "patient", "twilight", "dawn", "crimson", "wispy", "weathered", "blue",
        "billowing", "frosty", "green", "cyan", "platinum", "oaken", "copper",
        "lingering", "bold", "morning", "aluminum", "jeweled", "crystal",
        "still", "small", "sparkling", "shy", "marble", "zinc",
        "wandering", "wild", "young", "solitary", "triangular", "mauve", "ringing",
        "fragrant", "snowy", "proud", "floral", "restless", "fizzy", "brilliant",
        "polished", "ancient", "purple", "lively", "lucky", "odd", "tiny", "bubbly",
        "orange", "gentle", "royal", "broad", "emerald", "magenta",
        "steep", "square", "round", "noisy", "soft", "gray", "azure", "citrine",
        "rapid", "sweet", "curly", "calm", "jolly", "fancy", "cerulean", "periwinkle",
        "effervescent", "peachy", "melodic", "whispering", "steep", "brave", "silver",
        "glamorous", "handsome", "quaint", "adorable", "elegant", "goldenrod"
    ];

    public static $NOUNS = [
        "waterfall", "river", "breeze", "moon", "rain", "sea", "morning",
        "lake", "sunset", "pine", "shadow", "leaf", "dawn", "spring",
        "forest", "hill", "cloud", "meadow", "sun", "glade", "brook",
        "butterfly", "dew", "dust", "field", "firefly",
        "feather", "grass", "haze", "mountain", "night", "pond", "darkness",
        "snowflake", "sky", "thunder", "lightning", ""
        "violet", "wave", "ocean", "dream", "cherry", "tree", "fog", "frost", 
        "frog", "smoke", "star", "atom", "catamaran", "piano",
        "heart", "lion", "tiger", "ocelot", "fox", "mantis", "wolf"
        "penguin", "kiwi", "cake", "mouse", "coyote", "elephant", "alpaca",
        "aardvark", "albatross", "anaconda", "antlion", "basilisk", "beetle",
        "jay", "bobcat", "camel", "capybara", "caribou", "caterpillar",
        "catfish", "cardinal", "chameleon", "cheetah", "chinchilla", "chipmunk",
        "koi", "condor", "crane", "crocodile", "crow", "dolphin", "dove",
        "eagle", "elk", "falcon", "flamingo", "gazelle", "gecko", "giraffe",
        "hedgehog", "ibex", "kangaroo", "koala", "ladybug", "lemur", "llama",
        "lynx", "lyrebird", "macaw", "marlin", "mockingbird", "moose", "moth",
        "newt", "narwhal", "otter", "owl", "parrot", "panda", "quail", "rhinoceros",
        "salamander", "seahorse", "starling", "tapir", "turtle", "wallaby", "walrus",
        "whale", "wren", "zebra", "dandelion", "tulip", "sunflower", "daffodil", "lilac",
        "marigold", "pearl"
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
