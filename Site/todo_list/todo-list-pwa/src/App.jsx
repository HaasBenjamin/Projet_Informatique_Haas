import Header from "./components/Header";
import Main from "./components/Main";
import useTodos from "./hooks/useTodos.js";
import {useEffect} from "react";

function App() {
    const { todos, isLoading, toggleTodo, deleteTodo, updateTodo, addTodo,networkError,checkNetwork } = useTodos();
    console.log('deb',networkError)
    useEffect(()=>{console.log('network', networkError)}, [networkError]);
    return (
    <>
        <Header networkError={networkError} checkNetwork={checkNetwork} />
        <Main todos={todos} toggleTodo={toggleTodo} isLoading={isLoading} deleteTodo={deleteTodo} updateTodo={updateTodo} addTodo={addTodo} networkError={networkError}/>
    </>
  )
}

export default App
