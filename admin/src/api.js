// src/api.js
//import axios from 'axios';
import { createClient } from "@supabase/supabase-js";
import axios from 'axios';

const supabase = createClient("https://rthogounxiwablkdbjfs.supabase.co", "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InJ0aG9nb3VueGl3YWJsa2RiamZzIiwicm9sZSI6ImFub24iLCJpYXQiOjE3Mjc2NTcwMTcsImV4cCI6MjA0MzIzMzAxN30.Vv6W6hGKzArS1674c_xtEijbQ42NPticNW48TMS_DIc", { db: { schema: 'realstate' } });

const bucketName = 'realstate';

const API_URL = 'http://localhost/casabela/api/controllers';

export const fetchDepartments = async () => {
  try {
    const { data } = await supabase.from("departments").select("*");
    return data;
  } catch (error) {
    console.error('Error fetching departments:', error);
    throw error;
  }
};

export const fetchProvinces = async (departmentId) => {
  try {
    const { data } = await supabase
      .from("provinces")
      .select("id, name")
      .eq("department_id", departmentId);
    return data;
  } catch (error) {
    console.error('Error fetching provinces:', error);
    throw error;
  }
};

export const fetchDistricts = async (provinceId) => {
  try {
    const { data } = await supabase
      .from("districts")
      .select("id, name")
      .eq("province_id", provinceId);
    return data;
  } catch (error) {
    console.error('Error fetching districts:', error);
    throw error;
  }
};

export const fetchPropertyTypes = async () => {
  try {
    const { data } = await supabase
      .from("property_types")
      .select("id, description")
    return data;
  } catch (error) {
    console.error('Error fetching districts:', error);
    throw error;
  }
};

export const createProperty = async (propertyData) => {
  try {
    //Remove properties which not belong to table
    delete propertyData['department_id'];
    delete propertyData['province_id'];

    //Send request
    const { data, error } = await supabase
      .from('properties')
      .insert(propertyData)
      .select();
    console.error(error);
    return data;
  } catch (error) {
    console.error('Error creating property:', error);
    throw error;
  }
};

export const fetchProperties = async (filters) => {
  try {
    console.log(filters);
    const { data } = await supabase
      .from("vwproperties")
      .select("*")
    return data;
    } catch (error) {
    console.error('Error fetching property:', error);
    throw error;
  }
};

export const fetchPropertyImages = async (propertyId) => {
  try {
    const { data } = await supabase
      .from("property_images")
      .select("id, image_path, alt_text")
      .eq("property_id", propertyId);
    return data;
    } catch (error) {
    console.error('Error fetching property:', error);
    throw error;
  }
};

export const uploadFile = async (propertyId, file) => {
  let result = { data: null, error: null}; 
  try {
    const formData = new FormData();
    formData.append('propertyId', propertyId);
    formData.append('file', file);

    axios.post(`${API_URL}/upload.php`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
      .then(response => {
        console.log(response.data); // Handle successful upload response
        result.data = response.data;
      })
      .catch(error => {
        console.error(error); // Handle upload errors
        result.error = error;
      });   
  }catch(error){
    console.error('Error fetching provinces:', error);
    throw error;
  }
  return result;
}

export const fetchUploadedImages = async (propertyId) => {
  const { data, error } = await supabase.storage
    .from(bucketName)
    .list('uploads', {
      limit: 100, // Puedes ajustar el límite según lo necesites
      offset: 0,
    });
  return { data, error };
}

export const fetchImage = async (imageFile) => {
const { publicURL } = supabase.storage
          .from(bucketName)
          .getPublicUrl(`uploads/${imageFile}`);
        return publicURL;
};
