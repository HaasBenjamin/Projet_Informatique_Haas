import {cleanupOutdatedCaches, precacheAndRoute} from "workbox-precaching";
import {registerRoute, Route} from 'workbox-routing';
import {NetworkFirst} from 'workbox-strategies';
import { ExpirationPlugin } from 'workbox-expiration';


precacheAndRoute(self.__WB_MANIFEST.filter((element) => element.url !== 'css/background.css'));

cleanupOutdatedCaches();

addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});

const todosRoute = new Route(({ request }) => {
    return request.url.includes(":7000/todos") && request.method === "GET"
}, new NetworkFirst({
    cacheName: 'todos',
    plugins: [
        new ExpirationPlugin({
            maxAgeSeconds: 60 * 60 * 24 * 30,
        })
    ]
}));
// Register the new route
registerRoute(todosRoute);


// self.addEventListener("fetch", (event) => {
//     if (event.request.method === "GET" && event.request.url.includes(":7000/todos")){
//         // Open the cache
//         event.respondWith(caches.open("todos").then((cache) => {
//             // Go to the network first
//             return fetch(event.request.url).then((fetchedResponse) => {
//                 cache.put(event.request, fetchedResponse.clone());
//                 return fetchedResponse;
//             }).catch(() => {
//                 // If the network is unavailable, get
//                 return cache.match(event.request.url);
//             });
//         }));
//     }
// });

const matchBackground = ({url, request, event}) => {
    return url.pathname === '/css/background.css';
};

const handlerBackGround = async ({url, request, event, params}) => {
    return (await fetch(request).catch(() => {
        // une réponse fabriquée avec un fond orange
        return new Response(".main {background: orange;}", {headers: {"Content-Type": "text/css"}});
    }));
};

registerRoute(matchBackground, handlerBackGround);
// self.addEventListener("fetch", (event) => {
//     // Si la requête cible une url contenant le fichier background.css
//     if (event.request.url.includes("background.css")) {
//         // La réponse produite sera
//         event.respondWith(
//             // Le résultat de la requête vers le fichier background.css
//             fetch(event.request)
//                 // Ou en cas d'échec
//                 .catch(() => {
//                     // une réponse fabriquée avec un fond orange
//                     return new Response(".main {background: orange;}", { headers: { "Content-Type": "text/css" }});
//                 })
//         )
//     }
// });


// self.addEventListener("fetch", (event) => {
//     event.respondWith(cacheFirst(event.request));
// });


// self.skipWaiting();
