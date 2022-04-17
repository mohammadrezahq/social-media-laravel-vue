import axios from "axios";

const connect = axios.create({
  baseURL: "http://localhost:8000/api/",
});

if (localStorage.getItem("token")) {
  const token = localStorage.getItem("token");
  connect.interceptors.request.use((config) => {
    config.headers.Authorization = `Bearer ${token}`;
    return config;
  });
}

export default connect;
