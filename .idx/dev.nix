# To learn more about how to use Nix to configure your environment
# see: https://developers.google.com/idx/guides/customize-idx-env
{ pkgs, ... }: {
  channel = "stable-24.05";
  packages = [
    pkgs.php81
    pkgs.phpPackages.composer
  ];
  idx = {
    extensions = [ "google.gemini-cli-vscode-ide-companion" ];
    previews = {
      enable = true;
      previews = {
        web = {
          command = [ "php" "-t" "public" "-S" "0.0.0.0:8000" ];
          manager = "web";
        };
      };
    };
  };
}