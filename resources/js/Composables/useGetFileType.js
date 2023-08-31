const WORD_FILE_TYPES = ['text/xml','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document']
export default function useGetFileType(type, url) {
   let fileType;
   let isImage = false;
   let isVideo = false;
   let isWord = false;
   let isPdf = false;
   let previewUrl = url;

   switch (true) {
      case type.startsWith("image/"):
         fileType = "image";
         isImage = true;
         break;
      case type.startsWith("video/"):
         fileType = "video";
         isVideo = true;
         break;
      case type.startsWith("application/pdf"):
         fileType = "pdf";
         isWord = true;
         previewUrl = "/images/pdf.png";
         break;
      case WORD_FILE_TYPES.includes(type):
         fileType = "word";
         isWord = true;
         previewUrl = "/images/doc.png";
         break;
      default:
         break;
   }
   return {
      type: fileType,
      isWord,
      isPdf,
      isImage,
      isVideo,
      previewUrl,
   };
}
