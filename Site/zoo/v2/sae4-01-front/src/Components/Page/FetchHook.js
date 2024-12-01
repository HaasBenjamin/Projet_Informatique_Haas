export const BASE_URL =
  process.env.REACT_APP_API_ENTRYPOINT ?? "http://localhost:8000/api";

export function fetchAllFamilies() {
  return fetch(`${BASE_URL}/animal_families`).then((response) =>
    response.json(),
  );
}

export function fetchAllAnimals(urlParams) {
  return fetch(`${BASE_URL}/animals?${urlParams}`).then((response) =>
    response.json(),
  );
}

export function fetchEnclosureAnimals(urlParams, enclosureId) {
  return fetch(
    `${BASE_URL}/enclosures/${enclosureId}/animals?${urlParams}`,
  ).then((response) => response.json());
}

export function getSpeciesNameById(urlParams) {
  return fetch(`${BASE_URL}/species/${urlParams.split("/").pop()}`).then(
    (response) => response.json(),
  );
}

export function getEnclosureNameById(urlParams) {
  return fetch(`${BASE_URL}/enclosures/${urlParams.split("/").pop()}`).then(
    (response) => response.json(),
  );
}

export function fetchAllSpecies(urlParams) {
  return fetch(`${BASE_URL}/species?${urlParams}`).then((response) =>
    response.json(),
  );
}

export function SpeciesDietName(dietId) {
  return fetch(`${BASE_URL}/species/${dietId}/diet`).then((response) =>
    response.json(),
  );
}
export function getAnimalById(urlParams) {
  return fetch(`${BASE_URL}/animals/${urlParams.split("/").pop()}`).then(
    (response) => response.json(),
  );
}

export function fetchAllAnimalCategory() {
  return fetch(`${BASE_URL}/animal_categories`)
    .then((response) => response.json())
    .then((json) => json["hydra:member"]);
}

export function fetchAllEvents() {
  return fetch(`${BASE_URL}/events`)
    .then((response) => response.json())
    .then((json) => json["hydra:member"]);
}
export function getEventById(id) {
  return fetch(`${BASE_URL}/events/${id}`).then((response) => response.json());
}
export function fetchAnimalsSpecies(urlParams, speciesId) {
  return fetch(`${BASE_URL}/species/${speciesId}/animals?${urlParams}`).then(
    (response) => response.json(),
  );
}
export function fetchSpeciesFamily(urlParams, familyId) {
  return fetch(
    `${BASE_URL}/animal_families/${familyId}/species?${urlParams}`,
  ).then((response) => response.json());
}

export function fetchAllEventDate() {
  return fetch(`${BASE_URL}/event_dates`).then((response) => response.json());
}
export function patchEvent(data) {
  fetch(`${BASE_URL}/events/${data.id}`, {
    method: "PATCH",
    headers: {
      Accept: "application/ld+json",
      "Content-Type": "application/merge-patch+json",
    },
    credentials: "include",
    body: JSON.stringify(data),
  })
    .then(() => {
      console.log("Evènement modifié !");
    })
    .catch((error) => {
      console.log(error);
    });
}

export function postImage(image) {
  const formData = new FormData();
  formData.append("image", image);
  return fetch(`${BASE_URL}/images`, {
    method: "POST",
    credentials: "include",
    body: formData,
  });
}

export function DeleteImage(imageId) {
  return fetch(`${BASE_URL}/images/${imageId}`, {
    method: "DELETE",
    credentials: "include",
  });
}

export function patchAnimal(data) {
  fetch(`${BASE_URL}/animals/${data.id}`, {
    method: "PATCH",
    headers: {
      Accept: "application/ld+json",
      "Content-Type": "application/merge-patch+json",
    },
    credentials: "include",
    body: JSON.stringify(data),
  })
    .then(() => {
      console.log("Animal modifié !");
    })
    .catch((error) => {
      console.log(error);
    });
}

export function deleteAnimal(animalId) {
  fetch(`${BASE_URL}/animals/${animalId}`, {
    method: "DELETE",
    credentials: "include",
    body: JSON.stringify({ id: animalId }),
  }).then(() => {});
}

export async function streamToString(stream) {
  const reader = stream.getReader();
  const decoder = new TextDecoder();
  let result = "";
  let readAll = false;

  while (!readAll) {
    const { done, value } = await reader.read();
    if (done) {
      readAll = true;
    }
    result += decoder.decode(value, { stream: true });
  }

  return result;
}

export function deleteEvent(id) {
  fetch(`${BASE_URL}/events/${id}`, {
    method: "DELETE",
    credentials: "include",
    body: JSON.stringify({ id }),
  }).then(() => {});
}
export function fetchEvent(eventId) {
  return fetch(`${BASE_URL}/events/${eventId}`).then((response) =>
    response.json(),
  );
}

export function postInscriptions(data) {
  return fetch(`${BASE_URL}/registrations`, {
    method: "POST",
    credentials: "include",
    body: data,
  });
}

export function patchInscription(id, data) {
  return fetch(`${BASE_URL}/registrations/${id}`, {
    method: "PATCH",
    headers: {
      Accept: "application/ld+json",
      "Content-Type": "application/merge-patch+json",
    },
    credentials: "include",
    body: data,
  });
}

export function fetchRegistration(inscriptionId) {
  return fetch(`${BASE_URL}/registrations/${inscriptionId}`, {
    credentials: "include",
  }).then((response) => response.json());
}

export function deleteInscription(inscriptionId) {
  fetch(`${BASE_URL}/registrations/${inscriptionId}`, {
    method: "DELETE",
    credentials: "include",
    body: JSON.stringify({ id: inscriptionId }),
  }).then(() => {});
}

export function fetchRegistrationsCollection() {
  return fetch(`${BASE_URL}/registrations`, {
    credentials: "include",
  }).then((response) => response.json());
}

export function fetchFamiliesCategory(categoryId, urlParams) {
  return fetch(
    `${BASE_URL}/animal_categories/${categoryId}/animal_families?${urlParams}`,
  ).then((response) => response.json());
}

export function fetchAllEnclosures(urlParams) {
  return fetch(`${BASE_URL}/enclosures?${urlParams}`).then((response) =>
    response.json(),
  );
}
