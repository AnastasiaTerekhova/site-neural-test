import {
    Body,
    Controller,
    Get,
    Post,
    UploadedFile,
    UploadedFiles,
    UseInterceptors,
} from '@nestjs/common';
import { FileInterceptor, FilesInterceptor } from '@nestjs/platform-express';
import { DeleteImage } from 'src/dto/delete-img.dto';
import { NetworkSettings } from 'src/dto/network-settings.dto';
import { NetworkCategory } from 'src/dto/network.dto';
import { NetworkService } from './network.service';

@Controller('network')
export class NetworkController {
    constructor(private readonly networkService: NetworkService) {}

    @Post('trainNetwork')
    getTrain(@Body() networkSetings: NetworkSettings): any {
        return this.networkService.run(
            networkSetings.epochs,
            networkSetings.batchSize,
            './model'
        );
    }

    @Post('predict')
    @UseInterceptors(FilesInterceptor('file'))
    getPredict(@UploadedFiles() files): any {
        return this.networkService.getPredict(files);
    }

    @Get('getDefaultNetwork')
    getDefaultNetwork(): any {
        return this.networkService.getDefaultNetwork();
    }

    @Post('saveTrainImage')
    @UseInterceptors(FileInterceptor('file'))
    saveTrainImage(
        @UploadedFile() file,
        @Body() category: NetworkCategory
    ): any {
        return this.networkService.saveTrainImage(file, category);
    }
    @Post('saveTestImage')
    @UseInterceptors(FileInterceptor('file'))
    saveTestImage(
        @UploadedFile() file,
        @Body() category: NetworkCategory
    ): any {
        return this.networkService.saveTestImage(file, category);
    }

    @Get('getAllTrainData')
    getAllTrainData(): any {
        return this.networkService.getAllTrainData();
    }

    @Get('getAllTestData')
    getAllTestData(): any {
        return this.networkService.getAllTestData();
    }

    @Post('deleteImg')
    deleteImg(@Body() delImg: DeleteImage): any {
        return this.networkService.deleteImg(delImg);
    }
}
