#! /bin/bash
read -p "In right folder? press enter to continue"
rm -rf ./bachelorproef_bontinck_lennert.gls
rm -rf ./bachelorproef_bontinck_lennert.glsdefs
rm -rf ./bachelorproef_bontinck_lennert2.gls
latexmk -pdf "bachelorproef_bontinck_lennert"
makeglossaries -pdf "bachelorproef_bontinck_lennert"
cp -R ./bachelorproef_bontinck_lennert.gls ./bachelorproef_bontinck_lennert2.gls
rm -rf ./bachelorproef_bontinck_lennert.gls
grep -v "setcounter{page}{df}" ./bachelorproef_bontinck_lennert2.gls > ./bachelorproef_bontinck_lennert.gls
latexmk -pdf "bachelorproef_bontinck_lennert"
latexmk -pdf "bachelorproef_bontinck_lennert"
biber "bachelorproef_bontinck_lennert"
latexmk -pdf "bachelorproef_bontinck_lennert"
latexmk -pdf "bachelorproef_bontinck_lennert"
rm -rf ./bachelorproef_bontinck_lennert2.gls
read -p "Done!"
clear