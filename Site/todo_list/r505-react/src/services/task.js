import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

export const taskApi = createApi({
  reducerPath: "taskApi",
  baseQuery: fetchBaseQuery({
    baseUrl: "https://iut-rcc-infoapi.univ-reims.fr/tasks/api",
  }),
  endpoints: (builder) => ({
    getMe: builder.query({
      query: () => `/me`,
    }),
    getTaskLists: builder.query({
      query: () => `/me/task_lists`,
    }),
    auth: builder.mutation({
      async queryFn(body, _queryApi, _extraOptions, fetchWithBQ) {
        const authResponse = await fetchWithBQ({
          url: "/auth",
          method: "POST",
          body,
        });
        if (authResponse.error) {
          return { error: authResponse.error };
        }

        const meResponse = await fetchWithBQ(`/me`);
        if (meResponse.error) {
          return { error: meResponse.error };
        }

        return { data: meResponse.data };
      },
    }),
  }),
});

export const { useGetMeQuery, useAuthMutation, useGetTaskListsQuery } = taskApi;
