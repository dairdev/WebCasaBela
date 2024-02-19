find public/. -type f -name '*.html' | xargs sed -i 's/src\/pages/public/g'
find public/. -type f -name '*.html' | xargs sed -i 's/.php/.html/g'
