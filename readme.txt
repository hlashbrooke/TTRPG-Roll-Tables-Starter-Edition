=== TTRPG Roll Tables ===
Contributors: Hugh Lashbrooke
Tags: ttrpg
Donate link: https://hlashbrooke.itch.io/
Requires at least: 6.0
Tested up to: 6.3
License: GPL v3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Create easy roll tables for tabletop role-playing games.

== Description ==

You've created an exciting tabletop role-playing game and you've released it to the world. Great work! Now you want to make it as easy as possible for GMs to craft their narrative within the world you created for them.

I'm sure your RPG comes replete with tables to be rolled on that will generate encounters, loot, information about locations, names of places, character details, and all manner of other details about your game. Sure, GMs could check what die they need to roll, make the roll, check what it means in the table, forget what the die result was and look back and forth between the die and table a few times, only then reading out the correct result...

OR they could have your website open on their phone and tap a button to get a result instantly.

That's what this plugin offers - an interface for creating roll tables inside your WordPress dashboard and making them available on your website for people to use at the tap of a button. You can see an example of this plugin in action on the roll tables for Kiwi Acres, a Mausritter campaign setting that I created: https://hughlashbrooke.com/gaming/kiwi-acres-roll-tables/

With this plugin you can:
* Create as many roll tables as you like
* Group & categorise your roll tables
* Display individual tables, or groups of tables, or a combination using a shortcode
* Set table items to be any text you like
* Set a table item to pull a random result from a different table (that's what the 'Treasure' table in the Kiwi Acres example above does)
* Have a table item run mathematical operations akin to something like "d20 x 10 gold coins"
* Import an existing list of table items into a roll table

That covers all the major options you would need for roll tables, but if there's anything else you think should be included please let me know by logging an issue on GitHub: https://github.com/hlashbrooke/TTRPG-Roll-Tables/issues

Roll tables can have a title along with an optional description and image. The dice notation for the table will be calculated automatically based on the number of items in the table, or you can specify a dice notation to use.

Roll tables are created as a custom post type and are compatible with the block editor and the classic editor.

== Frequently Asked Questions ==

= How do I add new table items? =

Table items have 3 options:
1. Text input
2. Math calculations
3. Pulling random items from a different table

Text input will display whatever you input. Math calculations accept a range from the lowest to highest possibilities (to simulate a dice roll) along with an optional modifier. If you select option 3 it will override any text or math input you have supplied.

You must save the post in order to save the roll table items - they will not be saved automatically.

= I have an existing d100 table - can I import that without having to type it all in? =

Yes! You can import existing data into any roll table - simply paste it into the import text area with each item on a new line and click 'import'. Imported items will be appended onto existing roll tables.

= Why doesn't the plugin do this incredibly specific thing that I want it to do? =

You mean I haven't thought of that and included it? Poor form! Please log an issue on the GitHub repo and I'll see what I can do: https://github.com/hlashbrooke/TTRPG-Roll-Tables/issues

== Screenshots ==

1. The simple, but powerful interface for creating tables.
2. Animation showing the roll table from the first screenshot in action

== Changelog ==

= 1.0 =
* First upload!