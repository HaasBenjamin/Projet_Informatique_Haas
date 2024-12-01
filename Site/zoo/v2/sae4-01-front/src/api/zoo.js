export const API_URL = process.env.REACT_APP_API_ENTRYPOINT ?? "http://localhost:8000";

export function getUserDetail(userId) {
  return fetch(`${API_URL}/api/users/${userId}`).then((response) => {
    if (response.status === 401) {
      throw new Error("401");
    }
    return response.json();
  });
}

export function getMe() {
  return fetch(`${API_URL}/api/me`, {
    credentials: "include",
  }).then((response) => {
    if (
      response.status === 401 ||
      response.status === 404 ||
      response.status === 302
    ) {
      return null;
    }
    return response.json();
  });
}

export function loginUrl() {
  return `${API_URL}/login`;
}

export function logoutUrl() {
  return `${API_URL}/logout`;
}
