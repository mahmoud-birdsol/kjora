import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const maximumUploadNumberOfFiles = computed(
   () => usePage().props.maximumUploadNumberOfFiles
);

const useGetAllowedUploadFiles = (files, newFile) => {
   let FilesCount = files.length;
   let availableSpace = maximumUploadNumberOfFiles.value - FilesCount;
   if (availableSpace <= 0) return [];
   if (availableSpace > 0) return (newFile = newFile.slice(0, availableSpace));
};
export default useGetAllowedUploadFiles;
