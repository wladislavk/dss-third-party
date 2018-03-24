# dentalsleepsolutions

> dss frontoffice vue app

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report
```

For detailed explanation on how things work, checkout the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).

## Run dev-server using Docker

```bash
# build the image
docker build -t ds3-vue --build-arg NODE_ENV=development .

# run a container, mount sources directory (use absolute path at Windows)
docker run --privileged --name ds3-client -d -p 8080:8080 -p 9222:9222 -v src:/opt/app/src ds3-vue

# cleanup
docker stop ds3-client && docker rm ds3-client
```

## Chromium Usage
```
xpra start :99
DISPLAY=:99 chromium-browser --headless --disable-gpu --remote-debugging-port=9222 https://www.chromestatus.com
```
