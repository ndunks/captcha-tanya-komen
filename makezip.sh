#!/bin/sh
ZIP_NAME="${PWD##*/}"
git archive HEAD --prefix=$ZIP_NAME/ --format=zip -o $ZIP_NAME.zip
