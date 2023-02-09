import { Module } from '@nestjs/common';
import { ConfigModule } from '@nestjs/config';
import { ServeStaticModule } from '@nestjs/serve-static';
import { join } from 'path';
import { NetworkModule } from './network/network.module';

@Module({
    imports: [
        ConfigModule.forRoot({
            envFilePath: `.env.${process.env.NODE_ENV}`,
        }),
        ServeStaticModule.forRoot({
            rootPath: join(__dirname, '..', 'src', 'dataset'),
        }),
        NetworkModule,
    ],
    controllers: [],
    providers: [],
})
export class AppModule {}
