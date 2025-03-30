export const BASE_URL = "https://iut-rcc-infoapi.univ-reims.fr";

export async function fetchAllBookmarks(urlParams) {
  // return fetch(BASE_URL).then((response) => response.json());
  const fet = await fetch(`${BASE_URL}/bookmarks/bookmarks?${urlParams}`);
  return fet.json();
}

export function avatarUrl(user) {
  return `${BASE_URL}${user}/avatar`;
}

export function getBookmarksDetail(id) {
  return fetch(`${BASE_URL}/bookmarks/bookmarks/${id}`);
}

export function getUserDetail(id) {
  return fetch(`${BASE_URL}/bookmarks/users/${id}`);
}

export function getUserBookmarks(urlParams) {
  return fetch(`${BASE_URL}/bookmarks/bookmarks?${urlParams}`);
}

export function getMe() {
  return fetch(`${BASE_URL}/bookmarks/me`, { credentials: "include" }).then(
    (response) =>
      response.json().then((json) => {
        if (json.status === 401) {
          return null;
        }
        return json;
      }),
  );
}

export function loginUrl() {
  return `${BASE_URL}/bookmarks/login?redirect=${encodeURIComponent(window.location)}`;
}

export function logoutUrl() {
  return `${BASE_URL}/bookmarks/logout`;
}
