var dataCacheName = 'ataboy-v1.0'
var cacheName = 'ataboy-v1.0'
var dataUrl = 'http://192.168.43.39/ataboy/'
var PATH = dataUrl
var filesToCache = [
   PATH + '/',
   PATH + '/index.html',
   PATH + '/js/jquery-3.2.1.min.js',
   PATH + '/js/main.js',
   PATH + '/css/main.css'
]
self.addEventListener('install', function(e) {
   e.waitUntil(caches.open(cacheName).then(function(cache) {
      return cache.addAll(filesToCache)
   }))
})
self.addEventListener('activate', function(e) {
   e.waitUntil(caches.keys().then(function(keyList) {
      return Promise.all(keyList.map(function(key) {
         if (key !== cacheName) {
            return caches.delete(key)
         }
      }))
   }))
})
self.addEventListener('fetch', function(e) {
   if (e.request.url.indexOf(dataUrl) === 0) {
      e.respondWith(fetch(e.request).then(function(response) {
         return caches.open(dataCacheName).then(function(cache) {
            cache.put(e.request.url, response.clone())
            return response;
         })
      }))
   } else {
      e.respondWith(caches.match(e.request).then(function(response) {
         return response || fetch(e.request)
      }))
   }
})