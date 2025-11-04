{ pkgs, ... }:

let
  # 1. Define the PHP package with all its extensions in one go.
  # This is the correct Nix pattern.
  php-with-extensions = pkgs.php82.withExtensions ({ enabled, all }: enabled ++ [
    all.bcmath
    all.ctype
    all.curl
    all.dom
    all.exif
    all.fileinfo
    all.gd
    all.gmp
    all.iconv
    all.intl
    all.mbstring
    all.mysqli
    all.openssl
    all.pdo
    all.pdo_mysql
    all.sqlite3
    all.zip
    all.zlib
    all.opcache
  ]);

  # 2. Create a start script that uses this new PHP package.
  start-script = pkgs.writeShellScriptBin "start-server" ''
    #!${pkgs.bash}/bin/bash
    ${php-with-extensions}/bin/php -S 0.0.0.0:$PORT -t public
  '';

in
{
  channel = "stable-24.05";
  packages = [
    # 3. List the packages to install.
    php-with-extensions
    pkgs.php82Packages.composer
    start-script
  ];
  idx = {
    extensions = [ "google.gemini-cli-vscode-ide-companion" ];
    previews = {
      enable = true;
      previews = {
        web = {
          # 4. Use the start script for the preview.
          command = [ "start-server" ];
          manager = "web";
        };
      };
    };
  };
}