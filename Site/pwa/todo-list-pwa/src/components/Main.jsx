import TodoList from "./TodoList";
import FormAddTodo from "./FormAddTodo.jsx";
import PropTypes from "prop-types";

export default function Main({ todos, isLoading, toggleTodo, deleteTodo, updateTodo, addTodo,networkError }) {
    return (
        <main className="main">
            {!networkError && <FormAddTodo addTodo={addTodo} />}
            <TodoList todos={todos} isLoading={isLoading} toggleTodo={toggleTodo} deleteTodo={deleteTodo} updateTodo={updateTodo} networkError={networkError} />
        </main>
    )
}

Main.propTypes = {
    todos: PropTypes.arrayOf(PropTypes.shape({
        id: PropTypes.number.isRequired,
        text: PropTypes.string.isRequired,
        done: PropTypes.bool.isRequired,
    })),
    addTodo: PropTypes.func.isRequired,
    isLoading: PropTypes.bool,
    deleteTodo: PropTypes.func.isRequired,
    toggleTodo: PropTypes.func.isRequired,
    updateTodo: PropTypes.func.isRequired,
    networkError: PropTypes.bool.isRequired,
};