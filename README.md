Fork from AlfredoRamos

### About

Hide extension for phpBB

[![Latest Stable Version](https://img.shields.io/github/tag/AlfredoRamos/phpbb-ext-hide.svg?label=stable&style=flat-square)](https://github.com/vinfrag/phpbb-ext-hide/releases)

Allows you to write `[hide]text[/hide]` or `[hide inline=1]text[/hide]` and it will hide the content to guests and for the users who never posted in the topic.

You can nest `[hide]` and use other BBCodes inside it.

### Features

- BBCodes can be nested
- It adds visual help to recognize content that will be hidden
- It can hide inline content
- It doesn't require extra configuration

### Requirements

- PHP 7.1.3 or greater
- phpBB 3.3 or greater

### Installation

- Download the [latest release](https://github.com/vinfrag/phpbb-ext-hide/releases)
- Decompress the `*.zip` or `*.tar.gz` file
- Copy the files and directories inside `{PHPBB_ROOT}/ext/vinfrag/hide/`
- Go to your `Administration Control Panel` > `Customize` > `Manage extensions`
- Click on `Enable` and confirm

### Preview
[![Logged in user who have already posted in the topic](https://i.imgur.com/OajNWkct.png)](https://i.imgur.com/OajNWkc.png)
[![Logged in user who never posted in the topic](https://i.imgur.com/xDbK3oUt.png)](https://i.imgur.com/xDbK3oU.png)
[![Guest user](https://i.imgur.com/xDbK3oUt.png)](https://i.imgur.com/xDbK3oU.png)

*(Click to view in full size)*

### Configuration

To customize the look and feel:

- Copy the `styles/prosilver/` directory into `styles/{STYLE}/`
- Edit the following files as needed
	- `styles/{STYLE}/theme/css/style.css`
	- `styles/{STYLE}/theme/css/colors.css`

**Note:** If your style doesn't inherit from `prosilver`, you should follow the steps above even if you don't want to change any file.

### Uninstallation

- Go to your `Administration Control Panel` > `Customize` > `Manage extensions`
- Click on `Disable` and confirm
- Go back to `Manage extensions` > `Hide` > `Delete data` and confirm

### Upgrade

- Uninstall the extension
- Delete all the files inside `{PHPBB_ROOT}/ext/vinfrag/hide/`
- Download the new version
- Install the extension

### Credits

Credit to AlfredoRamos https://github.com/AlfredoRamos/phpbb-ext-hide/

File `lock-closed.svg` from [Zoondicons](https://www.zondicons.com/) by [Steve Schoger](https://twitter.com/steveschoger) is licensed under [CC BY 4.0](https://creativecommons.org/licenses/by/4.0/)
