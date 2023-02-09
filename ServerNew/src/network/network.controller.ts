import {
    Body,
    Controller,
    Get,
    Post,
    UploadedFiles,
    UseInterceptors,
} from '@nestjs/common';
import { FilesInterceptor } from '@nestjs/platform-express';
import { NetworkService } from './network.service';

@Controller('network')
export class NetworkController {
    constructor(private readonly networkService: NetworkService) {}

    @Get('trainNetwork')
    getTrain(): any {
        return this.networkService.run(100, 32, './model');
    }

    @Post('predict')
    @UseInterceptors(FilesInterceptor('file'))
    getPredict(@UploadedFiles() files): any {
        return this.networkService.getPredict(files);
    }
}
