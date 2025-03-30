export const API_URL = "http://movies-api";

export function getAllMovies(urlSearchParams = new URLSearchParams("page=1"),controller) {
  if (urlSearchParams instanceof URLSearchParams) {
    const signal = controller.signal;
    return fetch(`${API_URL}/movies?${urlSearchParams.toString()}`, {
      signal,
    }).then((response) =>
        // eslint-disable-next-line no-use-before-define
        extractCollectionAndPagination(response),
    );
  }
  return Promise.reject();
}

export function posterUrl(imagePath, size = "original") {
  return encodeURI(`${API_URL}${imagePath}/${size}`);
}

export function extractPaginationFromHeaders(response) {
  const current = parseInt(response.headers.get("Pagination-Current-Page"), 10);
  const last = parseInt(response.headers.get("Pagination-Last-Page"), 10);
  return { current, last };
}

export function extractCollectionAndPagination(response) {
  return response.json().then((rep) => ({
    pagination: extractPaginationFromHeaders(response),
    collection: rep,
  }));
}
