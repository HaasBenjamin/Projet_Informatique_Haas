import { getAllMovies, posterUrl } from "./movies-api";

let controller = new AbortController();
export function createMovieElt(movieData) {
  const article = document.createElement("article");
  article.className = "movie-item";
  article.innerHTML = `
  <img class="movie-item__poster" src="${posterUrl(
    movieData.poster,
    "medium",
  )}" alt="poster of '${movieData.title}'">
`;

  const div = document.createElement("div");
  div.className = "movie-item__info";
  const div2 = document.createElement("div");
  div2.className = "movie-item__title";
  div2.innerHTML = movieData.title;
  div.appendChild(div2);
  article.appendChild(div);
  return article;
}

export function updateMoviesElt(page = 1) {
  // eslint-disable-next-line no-use-before-define
  setLoading();
  const params = new URLSearchParams(`page=${page}`);
  // eslint-disable-next-line no-use-before-define
  appendSortToQuery(params);
  controller.abort();
  controller = new AbortController();
  getAllMovies(params, controller)
    .then((movies) => {
      // eslint-disable-next-line no-use-before-define
      updatePaginationElt(movies.pagination);
      // eslint-disable-next-line no-use-before-define
      emptyElt(document.querySelector("article.movies-list"));
      movies.collection.forEach((movie) => {
        const art = createMovieElt(movie);
        const article = document.querySelector("article.movies-list");
        article.appendChild(art);
      });
    })
    .catch(() => {});
}

export function createPaginationButtonElt(materialIcon, isDisabled, page) {
  const but = document.createElement("button");
  but.type = "button";
  but.className = "button";
  but.disabled = isDisabled;
  const span = document.createElement("span");
  span.className = "material-symbols-outlined";
  span.innerHTML = materialIcon;
  but.appendChild(span);
  but.addEventListener("click", () => {
    updateMoviesElt(page);
  });
  return but;
}

export function emptyElt(elt) {
  while (elt.hasChildNodes()) {
    elt.removeChild(elt.firstChild);
  }
}

export function updatePaginationElt(pagination) {
  if (pagination.last !== 1) {
    const nav = document.querySelector("nav.pagination");
    const fp = createPaginationButtonElt(
      "first_page",
      pagination.current === 1,
      1,
    );
    nav.appendChild(fp);
    const bef = createPaginationButtonElt(
      "navigate_before",
      pagination.current === 1,
      pagination.current - 1,
    );
    nav.appendChild(bef);
    const pageinfo = document.createElement("span");
    pageinfo.className = "pagination__info";
    pageinfo.innerHTML = `${pagination.current}/${pagination.last}`;
    nav.appendChild(pageinfo);
    const next = createPaginationButtonElt(
      "navigate_next",
      pagination.current >= pagination.last,
      pagination.current + 1,
    );
    nav.appendChild(next);
    const last = createPaginationButtonElt(
      "last_page",
      pagination.current >= pagination.last,
      pagination.last,
    );
    nav.appendChild(last);
  }
}
export function setLoading() {
  emptyElt(document.querySelector("nav.pagination"));
  const art = document.querySelector("article.movies-list");
  art.innerHTML = `<article class="loading">Loading...</article>`;
}

export function appendSortToQuery(urlSearchParams) {
  const radio = document.querySelector("input[type='radio']:checked").value;
  urlSearchParams.append(radio, "asc");
}

export function setSortButtonsEltsEvents() {
  document.querySelector("fieldset.sort").addEventListener("change", () => {
    updateMoviesElt();
  });
}

export function setFiltersDisplay(filtersElt, isSelectionMode) {
  filtersElt
    .querySelector("button.button.filters__add")
    .classList.toggle("hidden", isSelectionMode);
  filtersElt
    .querySelector("div.filters__list")
    .classList.toggle("hidden", isSelectionMode);
  filtersElt
    .querySelector("label.search")
    .classList.toggle("hidden", !isSelectionMode);
  filtersElt
    .querySelector("div.filters__propositions")
    .classList.toggle("hidden", !isSelectionMode);
}

export function setFiltersEltsEvents() {
  const but = document.querySelector("button.button.filters__add");
  but.addEventListener("click", () => {
    setFiltersDisplay(document.querySelector("fieldset.filters"), true);
  });
  document.addEventListener("click", (event) => {
    if (!document.querySelector("fieldset.filters").contains(event.target)) {
      setFiltersDisplay(document.querySelector("fieldset.filters"), false);
    }
  });

}

export function getAllKeywords(abortController, text) {
  getAllMovies(null, abortController).then((movies) => {
    const col = [];
    movies.collection.forEach((movie) => {
      if (movie.title.includes(text)) {
        col.push(movie);
      }
    });
    return { collection: col, pagination: movies.collection.pagination };
  });
}

export function handleKeywordsSearch(filtersElt, text){
  controller.abort();
  controller = new AbortController();
  const div = document.querySelector("div.filters__propositions");
  div.innerHTML = `<div class="loading">Loading...</div>`;
}
