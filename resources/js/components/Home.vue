<template>
    <div class="p-4 sm:ml-64">
        <div class="flex justify-between p-4 mt-14">
            <div class="text-start">
                <p class="font-semibold text-xl">Homilías</p>
            </div>
            <div class="text-end">
                <RouterLink :to="{ name: 'homilyAddView' }"
                    class="bg-sky-500 hover:bg-sky-600 text-gray-800 py-2 px-4 rounded inline-flex items-center"
                    title="Ver más">
                    <i class="fa-solid fa-circle-plus text-white"></i>
                    <span class="text-white">Agregar</span>
                </RouterLink>
            </div>
        </div>
        <Table :dataHomilies="dataHomilies" :columns="columnConfig" @editar="editar" @datelle="datelle"
            @eliminar="eliminar" />
    </div>
</template>
  
<script setup>
import { onMounted, ref } from "vue";
import Table from "../components/Admin/Table.vue";
import { initFlowbite } from "flowbite";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const dataHomilies = ref([]);
const getDataHomilies = async () => {
    try {
        const { data } = await axios.get('/getHomilies');
        dataHomilies.value = data;
    } catch (error) {
        console.error("Error al obtener los datos de Homilies:", error);
    }
};
const columnConfig = [
    { key: "date", label: "Fecha de evangelio" },
    { key: "citation", label: "Cita Bíblica" },
    { key: "title", label: "Título" },
    { key: "reading", label: "Lectura" },
    { key: "options", label: "Opciones" },
];


const editar = (id) => {
    router.push({ name: 'editHomily', params: { id: id } });
}
const datelle = (id) => {
    router.push({ name: 'detailHomily', params: { id: id } });
}
const eliminar = async (id = null) => {
    const { data } = await axios.delete('/getHomilies/' + id, config);
    if (data) {
        if (data.data === "ok") {
            Swal.fire("Correcto!", data.message, "success");
            getDataHomilies();
        } else {
            Swal.fire("Atención!", response.data.message, "warning");
        }
    }
};

onMounted(() => {
    initFlowbite();
    getDataHomilies();
});
</script>
  