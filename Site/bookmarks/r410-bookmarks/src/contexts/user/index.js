import { createContext } from "react";
import { getMe } from "../../services/api/bookmarks";

const LevelContext = createContext(getMe());
export default LevelContext;
