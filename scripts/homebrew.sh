#!/usr/bin/env sh

# Homebrew
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install.sh)"

 (echo; echo 'eval "$(/opt/homebrew/bin/brew shellenv)"') >> /Users/jbownds/.zprofile

eval "$(/opt/homebrew/bin/brew shellenv)"

brew upgrade

