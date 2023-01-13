#  Pizza Time 🍕
A high-school project I made in 2021.

The project was tested using [XAMPP](https://www.apachefriends.org/download.html) (Apache and MySQL services).

You can see an almost complete **design draft** (almost all in Italian) in [the Figma file](https://www.figma.com/community/file/1129093434431065312). If you want you can have a copy and get ideas from that.

The ["production" website](https://gabrieldn5j.altervista.org/) is hosted on [AlterVista](https://altervista.org).

## Notes
- The website can store users through a registration process. There sould probably be some consent for this but the entire project is just for demonstration purposes, so there's probably no need to do anything specifically. You can always test with a dummy account.
- You can see only `.less` files. You have to compile them.
I use an extension in Visual Studio Code called _[Easy LESS](https://marketplace.visualstudio.com/items?itemName=mrcrowl.easy-less)._
- The position and the photos have been taken from Google Images and an italian pizzeria called "Mondopizza da Ale".
- SQL credentials are empty (of course)
- Yes, there's a small easter egg. It's just a private joke with friends

## Known Errors / Issues — Forgive me, it was my first (and last) big project for school
- `503` page has no translation
- Some page and image file names are in Italian
- The code in the production website is not obfuscated
- Invoice process / user history is totally missing due to time constraints during implementation
- There are many TODOs left, and there they will remain ¯\\\_(ツ)\_\/¯

## Specific instructions when testing the project locally
- You should import the SQL dump I made in `initial_import.php`: it contains all basic pizza ingredients and menu items.

- If you store the project in a subfolder / in a different directory from the `htdocs` one provided by XAMPP, inside the `httpd.conf` file you should specify this instruction (or update the existing one). Without this instruction, the root folder is different from the one that the website expects.
	```ApacheConf
	DocumentRoot "your/project/full-path/folder"
	```
- To allow redirects to the `.php` and `.html` files without specifying the extension (e.g. you would like to see the URL `localhost/home` instead of `localhost/home.php`):
	```ApacheConf
	<Directory "your/root/folder"> # default directory is "C:/xampp/htdocs" (on Windows)
		<IfModule mod_rewrite.c>
			RewriteEngine On
			RewriteCond %{REQUEST_FILENAME}.php -f
			RewriteRule (.*) $1.php [L]
			RewriteCond %{REQUEST_FILENAME}.html -f
			RewriteRule (.*) $1.html [L]
		</IfModule>
	</Directory>
	```