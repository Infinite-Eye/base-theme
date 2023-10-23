# Installation

1. Forking into a private repo, by default github does not allow forking into anything other than a public repo.
```
git clone --bare git@github.com:Infinite-Eye/base-theme.git
cd base-theme
git push --mirror git@github.com:Infinite-Eye/new-repo-name.git
cd ..
rm -rf base-theme/
git clone git@github.com:Infinite-Eye/new-repo-name.git infinite-eye
cd infinite-eye/
git remote add upstream git@github.com:Infinite-Eye/base-theme.git
git remote set-url --push upstream DISABLE
git remote -v
```
2. Install NPM Dependencies.
```
npm i --include=dev
```
3. Install Composer Dependencies
```
composer install
```
4. Build Project
```
npm run start
```

Fetch changes from upstream fork
```
git fetch upstream
git rebase upstream/master
```


## Output Images

### Display image full size
```php
echo \InfiniteEye\Theme\Media::image(6);
```

### Display image relative to assets/img path
```php
echo \InfiniteEye\Theme\Media::image('image.png');
```

### Display image from acf field
```php
echo \InfiniteEye\Theme\Media::image(get_field('profile_image'));
```

### Output image specific size
```php
echo \InfiniteEye\Theme\Media::image(6)
    ->size('thumbnail');
```

### Output image dynamic size
```php
echo \InfiniteEye\Theme\Media::image(6)
    ->size(100);
```

### Output image with specific srcset sizes
```php
echo \InfiniteEye\Theme\Media::image(6)
    ->srcset([
        // at 1024 display 400px wide image
        1024 => 400,
        // at 768 display 200px wide image
        768 => 200,
        // at 480 display 100px wide image
        480 => 100
    ])
    ->size(500);
```
