<p align="center">
  <!-- Light Mode -->
  <img src="icons/mmubuddy-logo-dark.svg#gh-light-mode-only" alt="MMU|BUDDY Logo" width="250">
  <!-- Dark Mode -->
  <img src="icons/mmubuddy-logo-light.svg#gh-dark-mode-only" alt="MMU|BUDDY Logo" width="250">
</p>

[![License:
MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Made with
PHP](https://img.shields.io/badge/Made%20with-PHP-777bb4.svg?logo=php&logoColor=white)](https://www.php.net/)
[![PWA Ready](https://img.shields.io/badge/PWA-ready-blueviolet.svg)]()

MMU\|BUDDY is a lightweight web application to manage the slots of the
**Prusa MMU**.\
Configuration is saved in `config.json`, enabling device-independent
usage.

------------------------------------------------------------------------

## ✨ Features

-   Manage filament slots with selectable **brand, material, and color**
-   Activate or deactivate slots (currently up to **5 slots**)
-   Set a custom **printer name**
-   Filament brands and materials are editable via `brands.json` and
    `material.json`
-   **PWA support** -- install on your smartphone or tablet for a
    native-like experience
-   **Localization** support for many languages -- missing yours? Add it
    easily!

------------------------------------------------------------------------

## ⚙️ Requirements

-   **PHP 7.4+** with modules:
    -   `fpm`
    -   `json`
    -   `session`
-   A working web server (e.g., Apache, Nginx)

------------------------------------------------------------------------

## 🚀 Installation

1.  Clone the repository:

    ``` bash
    git clone https://github.com/<your-username>/MMU-BUDDY.git
    ```

2.  Place the project in your web server's root directory.

3.  Ensure `config.json`, `brands.json`, and `material.json` are
    writable by the server.

4.  Open the app in your browser and start managing your MMU slots.

------------------------------------------------------------------------

## 📖 Usage

-   Select brand, material, and color for each slot\
-   Activate or deactivate slots as needed\
-   Set a printer name\
-   All changes are saved automatically to `config.json` and are shared
    across devices

------------------------------------------------------------------------

## 🌍 Localization

MMU\|BUDDY already supports multiple languages.\
If your language is missing, contributions are highly encouraged!

------------------------------------------------------------------------

## 🔮 Future Plans

-   Add support for **multiple printers** (add/remove)

------------------------------------------------------------------------

## 🙋 About

I am not a professional developer -- this project is a **hobby project**
created for fun,\
with the help of **basic knowledge and AI**.

🛠️ Contributions, feedback, and suggestions are always welcome!

------------------------------------------------------------------------

🎉 Enjoy managing your Prusa MMU with **MMU\|BUDDY**!
