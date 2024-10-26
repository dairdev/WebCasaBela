// src/api.js
import axios from 'axios';

const API_URL = 'http://localhost:8000/api'; // Asegúrate de que la URL es la correcta

export const fetchDepartments = async () => {
  try {
    const response = await axios.get(`${API_URL}/departments`);
    return response.data;
  }catch(error){
    console.error('Error fetching provinces:', error);
    throw error;
  }
};

export const fetchProvinces = async (departmentId) => {
  try {
    const response = await axios.get(`${API_URL}/provinces`, {
      params: { department_id: departmentId },
    });
    return response.data;
    } catch (error) {
    console.error('Error fetching districts:', error);
    throw error;
  }
};

export const fetchDistricts = async (provinceId) => {
  try {
    const response = await axios.get(`${API_URL}provinces/${provinceId}/districts`, {
      params: { province_id: provinceId },
    });
    return response.data;
    } catch (error) {
    console.error('Error fetching districts:', error);
    throw error;
  }
};

export const fetchPropertyTypes = async () => {
  try {
    const response = await axios.get(`${API_URL}/propertytypes`);
    return response.data;
  } catch (error) {
    console.error('Error fetching districts:', error);
    throw error;
  }
};

export const createProperty = async (propertyData) => {
  try {
    const response = await axios.post(`${API_URL}/properties`, propertyData);
    return response.data;
  } catch (error) {
    console.error('Error creating property:', error);
    throw error;
  }
};

export const fetchPropertyImages = async (propertyId) => {
  try {
    const response = await axios.get(`${API_URL}/properties`, propertyId);
    return response.data;
    } catch (error) {
    console.error('Error fetching property:', error);
    throw error;
  }
};

export const fetchProperties = async (filters) => {
  try {
    const response = await axios.get(`${API_URL}/properties`, filters);
    return response.data;
    } catch (error) {
    console.error('Error fetching property:', error);
    throw error;
  }
};

export const uploadFile = async (image) => {
  try {
    const response = await axios.get(`${API_URL}/property/upload`, image);
    return response.data;
  } catch (error) {
    console.error('Error fetching districts:', error);
    throw error;
  }
};

