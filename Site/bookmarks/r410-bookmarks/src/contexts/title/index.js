import { createContext, useEffect, useState } from "react";

export function getRandomColor() {
  const letters = "0123456789ABCDEF";
  let color = "#";
  for (let i = 0; i < 6; i += 1) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}
export function TitleContext() {
  const [color, setColor] = useState("green");
  useEffect(() => {
    setColor(getRandomColor());
  }, []);
  return createContext({ color, setColor });
}
