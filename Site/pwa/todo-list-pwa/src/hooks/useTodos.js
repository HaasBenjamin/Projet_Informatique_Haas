import {useEffect, useState} from "react";
import {addApiTodo, deleteApiTodo, getApiTodos, isApiReachable, updateApiTodo} from "../services/todos.js";

export default function useTodos() {
    const [todos, setTodos] = useState([]);
    const [isLoading, setLoading] = useState(true);
    const [networkError, setNetworkError] = useState(true);

    useEffect(() => {
        getAllTodos()
            .catch((err) => {
                /* Network error */
                console.log(err.message);
            });
    }, []);

    const checkNetwork =  () => {
        isApiReachable().then(()=>{window.location.reload()}).catch(()=>{setNetworkError(true)});
    }

    useEffect(() => {
        window.addEventListener("offline", () => {
            checkNetwork();
        });

        window.addEventListener("online", () => {
            checkNetwork();
        });
    }, []);


    const getAllTodos = async function() {
        try {
            setTodos(await getApiTodos());
            setLoading(false);
            setNetworkError(false);
        } catch (e) {
            setNetworkError(true);
        }
    }

    const getTodos = () => {
        console.log("get Todos");

        getAllTodos()
          .catch((err) => {
              /* Network error */
              console.log(err.message);
          });
    };

    const toggleTodo = (id) => {
        console.log("toggleTodo Todo :", id);

        const todoToUpdate = todos.find((todo) => todo.id === id);
        updateApiTodo({...todoToUpdate, done: !todoToUpdate.done})
          .then(() => getAllTodos())
          .catch((err) => {
              /* Network error */
              setNetworkError(true);
              console.log(err.message);
          });
    };

    const deleteTodo = (id) => {
        console.log("delete Todo :", id);

        deleteApiTodo(id)
          .then(() => getAllTodos())
          .catch((err) => {
              /* Network error */
              setNetworkError(true);
              console.log(err.message);
          });
    };

    const updateTodo = (id, text) => {
        console.log("update Todo :", id, text);
        const todoToUpdate = todos.find((todo) => todo.id === id);
        updateApiTodo({...todoToUpdate, text})
          .then(() => getAllTodos())
          .catch((err) => {
              /* Network error */
              setNetworkError(true);
              console.log(err.message);
          });
    };

    const addTodo = (text) => {
        console.log("add Todo :", text);

        addApiTodo(text)
          .then(() => getAllTodos())
          .catch((err) => {
              /* Network error */
              setNetworkError(true);
              console.log(err.message);
          });
    };

    return {
        todos,
        isLoading,
        toggleTodo,
        addTodo,
        deleteTodo,
        updateTodo,
        getTodos,
        networkError,
        checkNetwork
    }
}
