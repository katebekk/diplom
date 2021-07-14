from Builders.Editor.ImageEdittor import ImageEditor
from Builders.SectorParser.SectorParser import SectorParser
from Builders.Utils.Utils import Utils
from Builders.Сomparer.ImageComparer import ImageComparer


class CheckingDrawing(object):
    _util = Utils()
    _editor = ImageEditor()
    _parser = SectorParser()
    _comparer = ImageComparer()


    def checkDrawing(self,reference_path, drawing_path):
        result_msg = ""
        drawing_img = self._util.read_image_as_array(drawing_path)
        reference_img = self._util.read_image_as_array(reference_path)

        reference_bin = self._editor.binary_image_with_param(reference_img)
        drawing_bin = self._editor.binary_image_with_param(drawing_img)

        reference = self._editor.find_drawing(reference_bin)
        drawing = self._editor.find_drawing(drawing_bin)
        result,message = self._comparer.check_proportions(reference,drawing)
        result_msg = result_msg + message + ". "
        if not result:
            return drawing, result_msg, 0

        drawing = self._comparer.to_reference_size(reference, drawing)

        result_img, message, percent = self._comparer.compare_mse(reference, drawing)
        result_msg = result_msg + message
        return result_img, result_msg, percent




