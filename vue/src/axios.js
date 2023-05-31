import axios from "axios";

const axiosClient = axios.create({
    // baseURL: `${VITE_API_BASE_URL}/api`
    baseURL: "http://localhost:8010/api"
})

axiosClient.interceptors.response.use(response => {
    // console.log(response.data.data)
    return response;
})

export default axiosClient