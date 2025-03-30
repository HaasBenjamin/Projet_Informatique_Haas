let token = null;
let refreshToken = null;

async function sendMessage(event) {
  const client = await self.clients.get(event.clientId);
  if (!client) return;
  const auth = token == null ? "rejetée" : "accordée";
  // Envoi d'un message au client
  client.postMessage({
    msg: `Authentification ${auth}`,
    type: "notification",
  });
}

async function authenticate() {
  await self.clients.forEach((client) => {
    client.postMessage({
      type: "authentication",
    });
  });
}

async function disconnect() {
  await self.clients.forEach((client) => {
    client.postMessage({
      type: "disconnect",
    });
  });
}

self.addEventListener("fetch", (event) => {
  const { url } = event.request;
  if (url.includes("/tasks/api/auth")) {
    let resError = null;

    event.respondWith(
      fetch(event.request)
        .then((res) => {
          if (res.ok) return res.json();
          resError = res;
          throw new Error(resError.status);
        })
        .then((jsonRes) => {
          // Stockage des tokens
          token = jsonRes.token;
          refreshToken = jsonRes.refreshToken;

          sendMessage(event).then();
          authenticate().then();
          return new Response(null, { status: 200 });
        })
        .catch((err) => {
          console.error(err);
          disconnect().then();
          sendMessage(event).then();
          return resError;
        }),
    );
  } else if (url.includes("/tasks/api/")) {
    if (token == null) {
      disconnect().then();
      event.respondWith(new Response(null, { status: 401 }));
      return;
    }
    const modifiedHeaders = new Headers(event.request.headers);
    modifiedHeaders.set("Authorization", `Bearer ${token}`);

    const modifiedRequest = new Request(event.request, {
      headers: modifiedHeaders,
    });

    event.respondWith(fetch(modifiedRequest));
  }
});

self.skipWaiting();
